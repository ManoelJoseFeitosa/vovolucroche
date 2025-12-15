<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'weight',
        'production_days',
        'image_path',
        'is_active',
        'is_featured',
    ];

    /**
     * Casts para garantir tipos de dados corretos
     */
    protected $casts = [
        'price' => 'decimal:2',
        'weight' => 'decimal:3',
        'production_days' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];
}
