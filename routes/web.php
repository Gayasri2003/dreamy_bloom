<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

// Frontend Shop Routes (Dynamic Blade Templates)
Route::get('/', [ShopController::class, 'home'])->name('shop.home');
Route::get('/about', [ShopController::class, 'about'])->name('shop.about');
Route::get('/products', [ShopController::class, 'products'])->name('shop.products');
Route::get('/product/{slug}', [ShopController::class, 'productDetail'])->name('shop.product.detail');
Route::get('/contact', [ShopController::class, 'contact'])->name('shop.contact');
Route::post('/contact', [ShopController::class, 'contactSubmit'])->name('shop.contact.submit');
Route::get('/testimonials', [ShopController::class, 'testimonials'])->name('shop.testimonials');

// Jetstream/Fortify Authentication Routes
// GET routes for showing forms (Fortify only provides POST routes)
Route::get('/login', function () {
    return view('auth.login-customer');
})->middleware('guest')->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->middleware('guest')->name('register');


// PayHere Notify Route (must be outside auth middleware for PayHere server callbacks)
Route::post('/payment/payhere/notify', [\App\Http\Controllers\PaymentController::class, 'notify'])->name('payment.payhere.notify');


// Cart Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    
    // Customer Orders Routes
    Route::get('/my-orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{id}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    
    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/order/success/{order}', [CheckoutController::class, 'success'])->name('order.success');
    
    // PayHere Payment Routes
    Route::get('/payment/payhere/return', [\App\Http\Controllers\PaymentController::class, 'return'])->name('payment.payhere.return');
    Route::get('/payment/payhere/cancel', [\App\Http\Controllers\PaymentController::class, 'cancel'])->name('payment.payhere.cancel');
});


// Admin Routes
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use Illuminate\Support\Facades\Blade;

// Admin Login - Direct route with Blade compilation
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');


// Protected Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    
    // Resource Routes
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    
    // Contact Routes
    Route::get('contacts', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{id}', [\App\Http\Controllers\Admin\ContactController::class, 'show'])->name('contacts.show');
    Route::patch('contacts/{id}/status', [\App\Http\Controllers\Admin\ContactController::class, 'updateStatus'])->name('contacts.update-status');
    Route::delete('contacts/{id}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contacts.destroy');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
