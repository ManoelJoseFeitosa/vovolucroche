<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'password', 
        'cpf', 'phone', 'zipcode', 'street', 'number', 'district', 'city', 'state'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    // Mantive sua wishlist antiga caso ainda use, mas o sistema novo usa 'favorites' abaixo
    public function wishlist()
    {
        return $this->belongsToMany(Product::class, 'product_user')->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Novo Sistema de Favoritos
    |--------------------------------------------------------------------------
    */

    // Relação com a tabela 'favorites'
    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorites', 'user_id', 'product_id')->withTimestamps();
    }

    // Verifica se o usuário já favoritou um produto específico
    public function hasFavorited($product)
    {
        return $this->favorites()->where('product_id', $product->id)->exists();
    }
}
