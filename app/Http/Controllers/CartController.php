<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Exibir o Carrinho de Compras
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Cálculos Totais
        $totalPrice = 0;
        $totalProductionDays = 0;

        foreach($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
            // Somamos os dias de confecção de cada item (considerando produção sequencial)
            $totalProductionDays += $item['production_days'] * $item['quantity'];
        }

        return view('site.cart', compact('cart', 'totalPrice', 'totalProductionDays'));
    }

    /**
     * Adicionar produto ao carrinho
     */
    public function add($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // Se o produto já está no carrinho, aumenta a quantidade
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Se não, adiciona novo item
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image_path,
                "production_days" => $product->production_days
            ];
        }

        session()->put('cart', $cart);
        
        // Retorna com notificação
        return redirect()->back()->with('success', 'Produto adicionado ao carrinho com sucesso!');
    }

    /**
     * Remover produto do carrinho
     */
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Produto removido com sucesso!');
        }

        // CORREÇÃO: Redireciona de volta para o carrinho após excluir
        return redirect()->back();
    }
}
