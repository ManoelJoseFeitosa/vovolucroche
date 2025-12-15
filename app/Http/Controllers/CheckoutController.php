<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\ShippingService;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

class CheckoutController extends Controller
{
    public function index()
    {
        if(!session('cart') || count(session('cart')) == 0) return redirect()->route('shop');
        return view('site.checkout');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required', 'email' => 'required|email', 'phone' => 'required',
            'zipcode' => 'required', 'street' => 'required', 'number' => 'required',
            'district' => 'required', 'city' => 'required', 'state' => 'required',
        ]);
        session()->put('customer_address', $request->all());
        return redirect()->route('checkout.payment');
    }

    public function payment()
    {
        if(!session('customer_address')) return redirect()->route('checkout.index');
        
        $address = session('customer_address');
        $cart = session('cart');
        
        $shippingService = new ShippingService();
        $shippingOptions = $shippingService->calculate($address['zipcode'], $cart);

        return view('site.payment', compact('address', 'cart', 'shippingOptions'));
    }

    /**
     * Gera o Pedido e Redireciona para o Mercado Pago
     */
    public function placeOrder(Request $request)
    {
        $cart = session('cart');
        $address = session('customer_address');

        if(!$cart || !$address) return redirect()->route('shop');

        $request->validate(['shipping_option' => 'required'], ['shipping_option.required' => 'Selecione o frete.']);
        [$shippingMethod, $shippingCost] = explode('|', $request->shipping_option);

        // 1. Calcula Totais
        $totalProducts = 0;
        foreach($cart as $item) {
            $totalProducts += $item['price'] * $item['quantity'];
        }
        $finalTotal = $totalProducts + $shippingCost;

        // 2. Salva o Pedido no Banco
        $order = Order::create([
            'user_id' => auth()->id() ?? null,
            'customer_name' => $address['fullname'],
            'customer_email' => $address['email'],
            'customer_cpf' => $address['cpf'] ?? null,
            'customer_phone' => $address['phone'],
            'zipcode' => $address['zipcode'],
            'street' => $address['street'],
            'number' => $address['number'],
            'district' => $address['district'],
            'city' => $address['city'],
            'state' => $address['state'],
            'complement' => $address['complement'] ?? null,
            'total_price' => $finalTotal,
            'shipping_method' => $shippingMethod,
            'shipping_cost' => $shippingCost,
            'status' => 'pending',
        ]);

        foreach($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        session()->forget(['cart', 'customer_address']);

        // 3. Integração com Mercado Pago (DEBUG ATIVADO)
        try {
            MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));

            $client = new PreferenceClient();
            
            $preference = $client->create([
                "items" => [
                    [
                        "id" => "ORDER-" . $order->id,
                        "title" => "Pedido #" . $order->id . " - Vovó Lu Crochê",
                        "quantity" => 1,
                        "unit_price" => (float) $finalTotal
                    ]
                ],
                "payer" => [
                    "name" => $address['fullname'],
                    "email" => $address['email'],
                ],
                "back_urls" => [
                    "success" => route('checkout.success'),
                    "failure" => route('checkout.payment'),
                    "pending" => route('checkout.success')
                ],
                "auto_return" => "approved",
                "external_reference" => (string) $order->id
            ]);

            return redirect($preference->init_point);

        } catch (MPApiException $e) {
            // AQUI ESTÁ A MUDANÇA: Vamos ver o erro real do Mercado Pago
            $response = $e->getApiResponse();
            $content = $response ? $response->getContent() : 'Sem detalhes';
            
            dd([
                'ERRO API' => 'O Mercado Pago recusou a conexão.',
                'Status Code' => $e->getStatusCode(),
                'Resposta Detalhada' => $content,
                'Mensagem' => $e->getMessage()
            ]);

        } catch (\Exception $e) {
            // Erro genérico de código (ex: classe não encontrada)
            dd($e->getMessage(), $e->getTraceAsString());
        }
    }

    public function success()
    {
        return view('site.success');
    }
}
