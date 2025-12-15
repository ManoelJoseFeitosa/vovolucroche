<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Relação: O item pertence a um Pedido.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relação: O item se refere a um Produto original.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
