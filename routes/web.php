<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\CheckoutAuthController;
use App\Http\Controllers\CustomerAreaController;
// IMPORTANTE: Importando o Middleware de Admin que criamos
use App\Http\Middleware\AdminMiddleware; 
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

// Página de Contato e Envio
Route::get('/contato', [ShopController::class, 'contact'])->name('contact');
Route::post('/contato/enviar', [ShopController::class, 'sendContact'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| Rotas do Carrinho de Compras
|--------------------------------------------------------------------------
*/
Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
Route::match(['get', 'post'], '/carrinho/adicionar/{id?}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/carrinho/remover', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::patch('/carrinho/atualizar', [CartController::class, 'updateCart'])->name('cart.update');
Route::get('/carrinho/frete', [CartController::class, 'calculateShipping'])->name('cart.shipping');
Route::post('/carrinho/frete/selecionar', [CartController::class, 'saveShipping'])->name('cart.shipping.save');

/*
|--------------------------------------------------------------------------
| Rotas de Checkout (Autenticação e Pagamento)
|--------------------------------------------------------------------------
*/

// 1. Identificação (Login/Cadastro Rápido) - Acessível se não estiver logado
Route::get('/finalizar-compra/identificacao', [CheckoutAuthController::class, 'index'])->name('checkout.auth');
Route::post('/finalizar-compra/registrar', [CheckoutAuthController::class, 'register'])->name('checkout.register');

// 2. Fluxo de Pagamento e Finalização
Route::get('/finalizar-compra', [CheckoutController::class, 'index'])->name('checkout.index'); // Redireciona para auth se não logado
Route::post('/finalizar-compra/salvar', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/pagamento', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::post('/finalizar-compra/confirmar', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::get('/pedido/sucesso', [CheckoutController::class, 'success'])->name('checkout.success');

/*
|--------------------------------------------------------------------------
| Área do Cliente (Protegidas)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard do Cliente (Acompanhamento e Histórico)
    Route::get('/minha-conta', [CustomerAreaController::class, 'dashboard'])->name('customer.dashboard');
    
    // Ações do Pedido (Confirmar Recebimento e Comprar Novamente)
    Route::put('/pedido/{id}/recebido', [CustomerAreaController::class, 'markAsReceived'])->name('customer.order.received');
    Route::post('/comprar-novamente/{orderId}', [CustomerAreaController::class, 'buyAgain'])->name('customer.buyAgain');
    
    // Avaliação de Produtos
    Route::post('/produto/avaliar', [CustomerAreaController::class, 'reviewProduct'])->name('customer.review');
});

/*
|--------------------------------------------------------------------------
| Rotas Administrativas (Protegidas por AdminMiddleware)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ALTERAÇÃO AQUI: Adicionado AdminMiddleware::class para proteger o grupo
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    
    // Gerenciamento de Produtos
    Route::resource('products', ProductController::class);
    
    // Gerenciamento de Pedidos
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    
    // Marcar como Enviado
    Route::post('/orders/{id}/ship', [AdminOrderController::class, 'markAsShipped'])->name('orders.ship');
});

/*
|--------------------------------------------------------------------------
| Rotas de Perfil (Breeze Padrão)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
