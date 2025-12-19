<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Product $product)
    {
        $user = Auth::user();

        if ($user->hasFavorited($product)) {
            $user->favorites()->detach($product->id); // Remove dos favoritos
            // Opcional: session()->flash('success', 'Removido dos favoritos.');
        } else {
            $user->favorites()->attach($product->id); // Adiciona aos favoritos
            // Opcional: session()->flash('success', 'Adicionado aos favoritos!');
        }

        return back(); // Volta para a página anterior
    }
}
