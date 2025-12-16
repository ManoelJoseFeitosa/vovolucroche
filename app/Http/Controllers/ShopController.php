<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ShopController extends Controller
{
    /**
     * Página Inicial (Home) - História e Destaques
     */
    public function index()
    {
        // ALTERAÇÃO: Busca apenas produtos marcados como 'is_featured'
        // Ordenado pelos mais recentes primeiro. Pegamos até 6 para ficar um grid bonito.
        $featuredProducts = Product::where('is_active', true)
                                   ->where('is_featured', true)
                                   ->latest()
                                   ->take(6)
                                   ->get();
        
        return view('site.home', compact('featuredProducts'));
    }

    /**
     * Página da Loja (Catálogo Completo)
     */
    public function catalog()
    {
        // Busca todos os produtos ativos, ordenados pelos mais novos
        $products = Product::where('is_active', true)->latest()->get();
        
        return view('site.shop', compact('products'));
    }

    /**
     * Página de Detalhes do Produto (Opcional, mas boa prática)
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('site.product', compact('product'));
    }

    /**
     * Página de Contato
     */
    public function sendContact(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);

        // Envia para o email da loja
        Mail::to('contato@vovolucroche.com.br')->send(new ContactMail($data));

        return redirect()->back()->with('success', 'Mensagem enviada com sucesso! Em breve retornaremos.');
    }
}
