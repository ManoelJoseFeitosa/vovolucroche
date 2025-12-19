<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Adiciona ou remove (toggle)
    public function toggle($productId)
    {
        $user = Auth::user();
        
        // O método toggle do Laravel verifica: se existe, remove; se não, cria.
        $result = $user->wishlist()->toggle($productId);

        $message = count($result['attached']) > 0 
            ? 'Produto adicionado à lista de desejos!' 
            : 'Produto removido da lista de desejos.';

        return back()->with('success', $message);
    }

    // Página para ver a lista
    public function index()
    {
        $products = Auth::user()->wishlist()->paginate(10);
        return view('wishlist.index', compact('products'));
    }
}
