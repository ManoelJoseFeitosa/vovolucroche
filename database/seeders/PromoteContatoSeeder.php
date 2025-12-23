<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class PromoteContatoSeeder extends Seeder
{
    public function run(): void
    {
        // Procura o usuário pelo e-mail e força ele a virar Admin
        $user = User::where('email', 'contato@vovolucroche.com.br')->first();

        if ($user) {
            $user->update(['is_admin' => true]);
            $this->command->info("Sucesso! O usuário contato@vovolucroche.com.br agora é Administrador.");
        } else {
            $this->command->error("Erro: Usuário não encontrado. Cadastre-se no site primeiro.");
        }
    }
}
