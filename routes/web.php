<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Públicas (Loja)
|--------------------------------------------------------------------------
*/

// Home (História e Capa)
Route::get('/', [ShopController::class, 'index'])->name('home');

// Loja (Catálogo de Produtos)
Route::get('/loja', [ShopController::class, 'catalog'])->name('shop');

// Detalhes do Produto
Route::get('/produto/{id}', [ShopController::class, 'show'])->name('shop.product');

// Página de Contato
Route::get('/contato', [ShopController::class, 'contact'])->name('contact');

// --- ROTAS DO CARRINHO DE COMPRAS ---
Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
Route::get('/carrinho/adicionar/{id}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/carrinho/remover', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::patch('/carrinho/atualizar', [CartController::class, 'updateCart'])->name('cart.update');
Route::get('/carrinho/frete', [CartController::class, 'calculateShipping'])->name('cart.shipping');

// --- ROTAS DE CHECKOUT (FINALIZAÇÃO) ---
Route::get('/finalizar-compra', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/finalizar-compra/salvar', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/pagamento', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::post('/finalizar-compra/confirmar', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::get('/pedido/sucesso', [CheckoutController::class, 'success'])->name('checkout.success');

/*
|--------------------------------------------------------------------------
| Rotas Administrativas (Protegidas)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupo de Rotas do Administrador (Unificado)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    
    // Gerenciamento de Produtos
    Route::resource('products', ProductController::class);
    
    // Gerenciamento de Pedidos
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
});

// Rotas de Perfil (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
