<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cria o usuário se ele não existir (baseado no email)
        User::updateOrCreate(
            ['email' => 'vovolu@teste.com'], // Email de login
            [
                'name' => 'Vovó Lu',
                'password' => Hash::make('12345678'), // Senha padrão
                'email_verified_at' => now(),
            ]
        );
    }
}
