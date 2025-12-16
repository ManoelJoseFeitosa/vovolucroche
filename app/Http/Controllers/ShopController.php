<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ShopController extends Controller
{
    /**
     * Página Inicial (Home)
     */
    public function index()
    {
        // CORREÇÃO AQUI: Mudamos de $products para $featuredProducts
        // Pegamos os 6 últimos para ficar bonito na grade (divisível por 3)
        $featuredProducts = Product::latest()->take(6)->get();
        
        return view('site.home', compact('featuredProducts'));
    }

    /**
     * Catálogo Completo (Loja)
     */
    public function catalog()
    {
        $products = Product::paginate(12);
        return view('site.shop', compact('products'));
    }

    /**
     * Detalhes do Produto
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        
        // Produtos relacionados
        $related = Product::where('id', '!=', $id)->inRandomOrder()->take(4)->get();

        return view('site.product', compact('product', 'related'));
    }

    /**
     * Página de Contato
     */
    public function contact()
    {
        return view('site.contact');
    }

    /**
     * Envia o E-mail de Contato
     */
    public function sendContact(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string'
        ]);

        try {
            // Certifique-se que o MAIL_USERNAME no .env está correto
            Mail::to('contato@vovolucroche.com.br')->send(new ContactMail($data));
            return redirect()->back()->with('success', 'Mensagem enviada com sucesso! Em breve retornaremos.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao enviar mensagem. Tente novamente mais tarde.');
        }
    }
}
