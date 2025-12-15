<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome da peça (ex: Tapete Redondo)
            $table->text('description'); // Detalhes da peça
            $table->decimal('price', 10, 2); // Preço (10 digitos, 2 decimais)
            $table->integer('production_days'); // Dias necessários para confecção
            $table->string('image_path')->nullable(); // Caminho da foto
            $table->boolean('is_active')->default(true); // Se o produto está visível na loja
            $table->timestamps(); // Cria created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
