<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Libera todos os campos para cadastro (Mass Assignment)
    // Isso é seguro pois validamos os dados no Controller
    protected $guarded = [];

    /**
     * Relação: Um pedido possui vários itens.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relação: Um pedido pertence a um usuário (opcional/pode ser null).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
