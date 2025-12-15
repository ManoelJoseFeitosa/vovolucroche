<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabela de Pedidos (Dados do Cliente e Endereço)
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Caso o usuário esteja logado
            
            // Dados do Cliente (Snapshot)
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_cpf')->nullable();
            $table->string('customer_phone');

            // Endereço de Entrega
            $table->string('zipcode');
            $table->string('street');
            $table->string('number');
            $table->string('district');
            $table->string('city');
            $table->string('state');
            $table->string('complement')->nullable();

            // Valores e Status
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending'); // pending, paid, shipped, delivered, canceled
            
            $table->timestamps();
        });

        // Tabela de Itens do Pedido (Quais produtos foram comprados)
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('product_name'); // Salvamos o nome caso o produto seja deletado depois
            $table->decimal('price', 10, 2); // Preço no momento da compra
            $table->integer('quantity');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
