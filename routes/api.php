<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\TestimonialController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ContactController;

// Public routes
Route::prefix('v1')->group(function () {
    
    // Products
    Route::get('/products', [ProductController::class, 'index']); // Get all products (with filters)
    Route::get('/products/{slug}', [ProductController::class, 'show']); // Get single product
    Route::get('/products/category/{slug}', [ProductController::class, 'byCategory']); // Products by category
    
    // Categories
    Route::get('/categories', [CategoryController::class, 'index']); // Get all categories
    Route::get('/categories/{slug}', [CategoryController::class, 'show']); // Get single category
    
    // Testimonials
    Route::get('/testimonials', [TestimonialController::class, 'index']); // Get all testimonials
    
    // Contact
    Route::post('/contact', [ContactController::class, 'store']); // Submit contact form
    
    // Auth routes
    Route::post('/register', [AuthController::class, 'register']); // Register new user
    Route::post('/login', [AuthController::class, 'login']); // Login user
    
    // Protected routes (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        
        // Auth
        Route::post('/logout', [AuthController::class, 'logout']); // Logout user
        Route::get('/user', [AuthController::class, 'user']); // Get authenticated user
        Route::put('/user/profile', [AuthController::class, 'updateProfile']); // Update profile
        Route::put('/user/password', [AuthController::class, 'updatePassword']); // Change password
        
        // Cart routes
        Route::get('/cart', [CartController::class, 'index']); // Get cart items
        Route::post('/cart', [CartController::class, 'store']); // Add item to cart
        Route::put('/cart/{id}', [CartController::class, 'update']); // Update cart item quantity
        Route::delete('/cart/{id}', [CartController::class, 'destroy']); // Remove cart item
        Route::delete('/cart', [CartController::class, 'clear']); // Clear all cart items
        
        // Orders
        Route::get('/orders', [OrderController::class, 'index']); // Get user orders
        Route::get('/orders/{id}', [OrderController::class, 'show']); // Get single order details
        Route::post('/orders', [OrderController::class, 'store']); // Create new order (checkout)
        Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel']); // Cancel order
        
        // Payment
        Route::post('/payment/initialize', [OrderController::class, 'initializePayment']); // Initialize PayHere payment
        Route::post('/payment/verify', [OrderController::class, 'verifyPayment']); // Verify payment status
    });
});

