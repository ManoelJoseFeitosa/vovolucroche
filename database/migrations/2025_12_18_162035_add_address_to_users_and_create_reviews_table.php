<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Adicionar campos de endereço ao usuário
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf')->nullable();
            $table->string('phone')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
        });

        // 2. Tabela de Avaliações
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('rating'); // 1 a 5 estrelas
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cpf', 'phone', 'zipcode', 'street', 'number', 'district', 'city', 'state']);
        });
    }
};
