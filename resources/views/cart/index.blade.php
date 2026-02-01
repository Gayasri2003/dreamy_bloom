@extends('layouts.modern')

@section('title', 'Shopping Cart - DreamyBloom')

@section('styles')
<style>
    .cart-page {
        background: linear-gradient(180deg, #F5E6F0 0%, #ffffff 40%);
        min-height: 100vh;
        padding-bottom: 60px;
    }
    
    .cart-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #C388B8 100%);
        padding: 80px 0 100px;
        position: relative;
        overflow: hidden;
    }
    
    .cart-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.3;
    }
    
    .cart-header-content {
        position: relative;
        z-index: 1;
        text-align: center;
        color: white;
    }
    
    .cart-header-content h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 15px;
        text-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .cart-header-content p {
        font-size: 1.2rem;
        opacity: 0.95;
    }
    
    .cart-icon-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        margin-bottom: 20px;
        backdrop-filter: blur(10px);
        border: 3px solid rgba(255, 255, 255, 0.3);
    }
    
    .cart-icon-badge i {
        font-size: 2.5rem;
    }
    
    .cart-container {
        max-width: 1200px;
        margin: -60px auto 0;
        padding: 0 20px;
        position: relative;
        z-index: 2;
    }
    
    .cart-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 30px;
        align-items: start;
    }
    
    .cart-items {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .cart-item-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(155, 93, 143, 0.08);
        display: grid;
        grid-template-columns: 120px 1fr auto;
        gap: 25px;
        align-items: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .cart-item-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, var(--primary-color), #C388B8);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .cart-item-card:hover {
        box-shadow: 0 8px 30px rgba(155, 93, 143, 0.15);
        transform: translateY(-2px);
    }
    
    .cart-item-card:hover::before {
        opacity: 1;
    }
    
    .cart-item-image {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 15px;
        background: var(--bg-pink);
    }
    
    .cart-item-placeholder {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, var(--bg-pink) 0%, var(--bg-light-pink) 100%);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 2.5rem;
    }
    
    .cart-item-details {
        flex: 1;
    }
    
    .cart-item-name {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
    }
    
    .cart-item-category {
        color: var(--text-gray);
        font-size: 0.95rem;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .cart-item-category i {
        color: var(--primary-color);
    }
    
    .cart-item-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .cart-item-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 20px;
    }
    
    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 12px;
        background: var(--bg-light-pink);
        padding: 8px 15px;
        border-radius: 50px;
        border: 2px solid var(--bg-pink);
    }
    
    .quantity-btn {
        width: 36px;
        height: 36px;
        border: none;
        background: white;
        color: var(--primary-color);
        border-radius: 50%;
        cursor: pointer;
        font-size: 1.2rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(155, 93, 143, 0.1);
    }
    
    .quantity-btn:hover {
        background: var(--primary-color);
        color: white;
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(155, 93, 143, 0.2);
    }
    
    .quantity-btn:active {
        transform: scale(0.95);
    }
    
    .quantity-display {
        min-width: 40px;
        text-align: center;
        font-weight: 600;
        font-size: 1.1rem;
        color: var(--text-dark);
    }
    
    .remove-btn {
        background: none;
        border: none;
        color: #e74c3c;
        cursor: pointer;
        font-size: 1.3rem;
        padding: 8px;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .remove-btn:hover {
        background: #ffe5e5;
        transform: scale(1.1);
    }
    
    .cart-summary {
        background: white;
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(155, 93, 143, 0.1);
        position: sticky;
        top: 100px;
    }
    
    .summary-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 2px solid var(--bg-pink);
    }
    
    .summary-header i {
        color: var(--primary-color);
        font-size: 1.5rem;
    }
    
    .summary-header h3 {
        margin: 0;
        font-size: 1.5rem;
        color: var(--text-dark);
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        padding: 12px 0;
    }
    
    .summary-row span:first-child {
        color: var(--text-gray);
        font-size: 1rem;
    }
    
    .summary-row strong {
        color: var(--text-dark);
        font-size: 1.1rem;
    }
    
    .summary-divider {
        margin: 25px 0;
        border: none;
        border-top: 2px dashed var(--border-color);
    }
    
    .summary-total {
        background: linear-gradient(135deg, var(--bg-pink) 0%, var(--bg-light-pink) 100%);
        padding: 20px;
        border-radius: 15px;
        margin: 25px 0;
    }
    
    .summary-total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .summary-total-row strong {
        font-size: 1.3rem;
        color: var(--text-dark);
    }
    
    .summary-total-row .total-amount {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .checkout-btn {
        width: 100%;
        padding: 18px;
        background: linear-gradient(135deg, var(--primary-color) 0%, #C388B8 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(155, 93, 143, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
    }
    
    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(155, 93, 143, 0.4);
    }
    
    .checkout-btn:active {
        transform: translateY(0);
    }
    
    .continue-shopping {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 18px;
        color: var(--text-gray);
        text-decoration: none;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    
    .continue-shopping:hover {
        color: var(--primary-color);
        gap: 12px;
    }
    
    .empty-cart {
        background: white;
        border-radius: 25px;
        padding: 80px 40px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(155, 93, 143, 0.08);
    }
    
    .empty-cart-icon {
        width: 150px;
        height: 150px;
        background: linear-gradient(135deg, var(--bg-pink) 0%, var(--bg-light-pink) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
    }
    
    .empty-cart-icon i {
        font-size: 5rem;
        color: var(--primary-color);
    }
    
    .empty-cart h3 {
        font-size: 2rem;
        margin-bottom: 15px;
        color: var(--text-dark);
    }
    
    .empty-cart p {
        color: var(--text-gray);
        font-size: 1.1rem;
        margin-bottom: 35px;
    }
    
    .badge-count {
        background: white;
        color: var(--primary-color);
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
    }
    
    @media (max-width: 968px) {
        .cart-grid {
            grid-template-columns: 1fr;
        }
        
        .cart-summary {
            position: static;
        }
        
        .cart-item-card {
            grid-template-columns: 100px 1fr;
            gap: 20px;
        }
        
        .cart-item-actions {
            grid-column: 1 / -1;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        
        .cart-header-content h1 {
            font-size: 2.2rem;
        }
    }
    
    @media (max-width: 576px) {
        .cart-item-card {
            grid-template-columns: 1fr;
            text-align: center;
        }
        
        .cart-item-image,
        .cart-item-placeholder {
            margin: 0 auto;
        }
        
        .cart-item-actions {
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')

<div class="cart-page">
    <!-- Cart Header -->
    <div class="cart-header">
        <div class="cart-header-content">
            <div class="cart-icon-badge">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h1>Shopping Cart</h1>
            <p>Review your items before checkout</p>
        </div>
    </div>

    <!-- Cart Content -->
    <div class="cart-container">
        @if($cartItems && count($cartItems) > 0)
            <div class="cart-grid">
                <!-- Cart Items -->
                <div class="cart-items">
                    @foreach($cartItems as $item)
                        <div class="cart-item-card">
                            <!-- Product Image -->
                            <div>
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="cart-item-image">
                                @else
                                    <div class="cart-item-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Details -->
                            <div class="cart-item-details">
                                <h3 class="cart-item-name">{{ $item->product->name }}</h3>
                                <div class="cart-item-category">
                                    <i class="fas fa-tag"></i>
                                    <span>{{ $item->product->category->name ?? 'Uncategorized' }}</span>
                                </div>
                                <div class="cart-item-price">
                                    Rs. {{ number_format($item->product->price, 2) }}
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="cart-item-actions">
                                <!-- Quantity Controls -->
                                <div class="quantity-controls">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                                        <button type="submit" class="quantity-btn">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </form>
                                    
                                    <span class="quantity-display">{{ $item->quantity }}</span>
                                    
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                        <button type="submit" class="quantity-btn">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- Remove Button -->
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove-btn" title="Remove from cart">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Cart Summary -->
                <div>
                    <div class="cart-summary">
                        <div class="summary-header">
                            <i class="fas fa-receipt"></i>
                            <h3>Order Summary</h3>
                        </div>
                        
                        <div class="summary-row">
                            <span>Items ({{ $cartItems->sum('quantity') }})</span>
                            <strong>Rs. {{ number_format($total, 2) }}</strong>
                        </div>
                        
                        <div class="summary-row">
                            <span><i class="fas fa-shipping-fast"></i> Shipping</span>
                            <strong>Rs. 300.00</strong>
                        </div>
                        
                        <hr class="summary-divider">
                        
                        <div class="summary-total">
                            <div class="summary-total-row">
                                <strong>Total</strong>
                                <span class="total-amount">Rs. {{ number_format($total + 300, 2) }}</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('checkout.index') }}" class="checkout-btn">
                            <i class="fas fa-lock"></i>
                            Proceed to Checkout
                        </a>
                        
                        <a href="{{ route('shop.products') }}" class="continue-shopping">
                            <i class="fas fa-arrow-left"></i>
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart State -->
            <div class="empty-cart">
                <div class="empty-cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h3>Your Cart is Empty</h3>
                <p>Looks like you haven't added anything to your cart yet.<br>Start shopping to fill it up!</p>
                <a href="{{ route('shop.products') }}" class="checkout-btn" style="max-width: 300px; margin: 0 auto;">
                    <i class="fas fa-shopping-bag"></i>
                    Browse Products
                </a>
            </div>
        @endif
    </div>
</div>

@endsection
