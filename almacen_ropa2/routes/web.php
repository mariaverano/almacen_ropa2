<?php
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;

Route::get('/', function () {
    // Si no hay sesión, enviar al login
    if (!session()->has('usuario_id')) {
        return redirect()->route('login');
    }

    // Si es admin, ir al dashboard, si no, a la lista de productos
    if (session('usuario_rol') === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('productos.index');
});

// Rutas públicas: redirección a productos
Route::resource('productos', ProductoController::class);
Route::resource('categorias', CategoriaController::class);
Route::middleware([\App\Http\Middleware\EnsureAdmin::class])->group(function () {
    Route::resource('pedidos', \App\Http\Controllers\PedidoController::class);
    Route::resource('pagos', \App\Http\Controllers\PagoController::class)->only(['index','store','destroy']);
});

// Rutas de autenticación (login/logout)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard administrador protegido con comprobación de sesión y rol
use App\Http\Controllers\AdminController;
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Rutas públicas de la tienda (shop)
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{id}', [ShopController::class, 'show'])->name('shop.show');
// Rutas de carrito/checkout (session-based)
Route::get('/cart', [ShopController::class, 'cart'])->name('cart.index');
Route::post('/cart/add', [ShopController::class, 'addToCart'])->name('cart.add');
Route::post('/checkout', [ShopController::class, 'checkout'])->name('checkout.store');
// Detalle público de pedido (confirmación)
Route::get('/order/{id}', [ShopController::class, 'orderShow'])->name('order.show');
// Mis pedidos (cliente)
Route::get('/my-orders', [ShopController::class, 'myOrders'])->name('shop.myorders');
// Ruta pública para registrar pagos desde la vista cliente (no protegida por EnsureAdmin)
Route::post('/pagos/public', [\App\Http\Controllers\PagoController::class, 'storePublic'])->name('pagos.public.store');