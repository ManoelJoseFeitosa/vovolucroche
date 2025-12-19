<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Models\Review;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request): RedirectResponse
    {
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function index()
    {
    $products = \App\Models\Product::take(8)->get(); // Seus produtos atuais
    
    // Busca reviews com nota 4 ou 5, pega 3 aleatórios
    $featuredReviews = Review::with('user') // Carrega quem fez o review
                             ->where('rating', '>=', 4)
                             ->inRandomOrder()
                             ->take(3)
                             ->get();

    return view('home', compact('products', 'featuredReviews'));
    }
}
