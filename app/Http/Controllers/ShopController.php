<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Mail; // Importante para o e-mail funcionar
use App\Mail\ContactMail; // Importante para usar a classe que criamos

class ShopController extends Controller
{
    /**
     * Página Inicial (Home)
     */
    public function index()
    {
        // Pega os 4 últimos produtos para exibir na capa (se houver essa seção)
        $products = Product::latest()->take(4)->get();
        return view('site.home', compact('products'));
    }

    /**
     * Catálogo Completo (Loja)
     */
    public function catalog()
    {
        // Exibe 12 produtos por página
        $products = Product::paginate(12);
        return view('site.shop', compact('products'));
    }

    /**
     * Detalhes do Produto
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        
        // Pega 4 produtos relacionados (aleatórios) para exibir embaixo
        $related = Product::where('id', '!=', $id)->inRandomOrder()->take(4)->get();

        return view('site.product', compact('product', 'related'));
    }

    /**
     * Página de Contato (NOVA - Resolve o seu Erro 500)
     */
    public function contact()
    {
        return view('site.contact');
    }

    /**
     * Envia o E-mail de Contato (NOVA)
     */
    public function sendContact(Request $request)
    {
        // 1. Valida os dados do formulário
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string'
        ]);

        // 2. Envia o e-mail usando a classe ContactMail
        // Certifique-se de que o MAIL_USERNAME no .env está correto
        try {
            Mail::to('contato@vovolucroche.com.br')->send(new ContactMail($data));
            return redirect()->back()->with('success', 'Mensagem enviada com sucesso! Em breve retornaremos.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao enviar mensagem. Tente novamente mais tarde.');
        }
    }
}
