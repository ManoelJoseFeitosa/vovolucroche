<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CheckoutAuthController extends Controller
{
    public function index() {
        return view('site.auth_checkout');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'cpf' => 'required',
            'phone' => 'required',
            'zipcode' => 'required',
            'street' => 'required',
            'number' => 'required',
            'district' => 'required',
            'city' => 'required',
            'state' => 'required',
        ]);

        // Cria o usuário
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cpf' => $request->cpf,
            'phone' => $request->phone,
            'zipcode' => $request->zipcode,
            'street' => $request->street,
            'number' => $request->number,
            'district' => $request->district,
            'city' => $request->city,
            'state' => $request->state,
        ]);

        // Loga o usuário
        Auth::login($user);

        // Salva na sessão para o CheckoutController usar
        session()->put('customer_address', $request->except(['password', '_token']));

        // Manda finalizar a compra
        return redirect()->route('checkout.payment');
    }
}
