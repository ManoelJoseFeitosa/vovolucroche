<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\ShippingService;

class CartController extends Controller
{
   public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        
        // 1. Calcula Dias de Confecção
        $totalProductionDays = 0;
        foreach($cart as $item) {
            $totalProductionDays += ($item['production_days'] * $item['quantity']);
        }

        // 2. Calcula Frete (se tiver CEP na URL)
        $shippingOptions = [];
        $zipcode = $request->query('zipcode');
        
        if ($zipcode) {
            $shippingService = new ShippingService();
            $shippingOptions = $shippingService->calculate($zipcode, $cart);
        }

        // 3. Verifica se já tem frete salvo na sessão
        $selectedShipping = session()->get('selected_shipping', null);
        
        // Se o usuário mudou o CEP, limpamos o frete selecionado antigo para evitar erros
        if ($zipcode && $selectedShipping && strpos(url()->previous(), 'zipcode') === false) {
             // Lógica opcional: se quiser forçar re-seleção quando muda CEP
        }

        return view('site.cart', compact('cart', 'totalProductionDays', 'shippingOptions', 'zipcode', 'selectedShipping'));
    }

    public function addToCart(Request $request, $id = null)
    {
        // Pega o ID ou do formulário (request) ou da URL ($id)
        $productId = $request->product_id ?? $id;

        if (!$productId) {
             return redirect()->back()->with('error', 'Produto inválido.');
        }

        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image_path,
                "production_days" => $product->production_days,
                "weight" => $product->weight
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Produto adicionado ao carrinho!');
    }

    // NOVA FUNÇÃO: Atualizar Quantidade
    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Carrinho atualizado!');
        }
        // Retorna para o carrinho mantendo o CEP se tiver
        return redirect()->route('cart.index', ['zipcode' => $request->zipcode]); 
    }

    public function removeFromCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Produto removido!');
        }
        return redirect()->back();
    }
    
    // Redireciona o form de frete para o index com os parâmetros
    public function calculateShipping(Request $request)
    {
        return redirect()->route('cart.index', ['zipcode' => $request->zipcode]);
    }

    public function saveShipping(Request $request)
    {
        // O valor vem no formato "Nome do Frete|Preço" (ex: "PAC|35.90")
        if ($request->shipping_option) {
            [$name, $price] = explode('|', $request->shipping_option);
            
            session()->put('selected_shipping', [
                'name' => $name,
                'price' => (float) $price
            ]);
            
            return redirect()->back()->with('success', 'Frete selecionado!');
        }
        
        return redirect()->back();
    }
}
