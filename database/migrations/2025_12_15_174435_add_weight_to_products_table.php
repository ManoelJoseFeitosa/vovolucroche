<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Adiciona a coluna 'weight' (Peso) após o preço.
            // Formato decimal (8 dígitos total, 3 decimais). Ex: 1.500 (1kg e meio)
            $table->decimal('weight', 8, 3)->nullable()->after('price'); 
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('weight');
        });
    }
};
