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
        
        // 1. Calcula o Total de Dias de Confecção (Soma de todos os itens)
        $totalProductionDays = 0;
        foreach($cart as $item) {
            // Se pedir 2 unidades de 5 dias, são 10 dias de produção
            $totalProductionDays += ($item['production_days'] * $item['quantity']);
        }

        // 2. Se tiver CEP na URL (do formulário de cálculo), calcula o frete
        $shippingOptions = [];
        $zipcode = $request->query('zipcode');
        
        if ($zipcode) {
            $shippingService = new ShippingService();
            $shippingOptions = $shippingService->calculate($zipcode, $cart);
        }

        return view('site.cart', compact('cart', 'totalProductionDays', 'shippingOptions', 'zipcode'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image_path,
                "production_days" => $product->production_days, // Importante para o cálculo
                "weight" => $product->weight
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produto adicionado ao carrinho!');
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
}
