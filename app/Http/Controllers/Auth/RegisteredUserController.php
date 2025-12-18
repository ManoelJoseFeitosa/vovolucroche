<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validação Completa (incluindo endereço)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'cpf' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'zipcode' => ['required', 'string'],
            'street' => ['required', 'string'],
            'number' => ['required', 'string'],
            'district' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
        ]);

        // 2. Criar Usuário com todos os dados
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
            'is_admin' => false, // Garante que é cliente
        ]);

        event(new Registered($user));

        Auth::login($user);

        // 3. MUDANÇA AQUI: Redireciona para a Loja (Shop) ao invés do Dashboard
        return redirect()->route('shop');
    }
}
