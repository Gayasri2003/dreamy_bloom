@extends('layouts.modern')

@section('title', 'Checkout - DreamyBloom')

@section('styles')
<style>
    .checkout-header {
        background: linear-gradient(135deg, var(--bg-pink) 0%, var(--bg-light-pink) 100%);
        padding: 60px 0;
        text-align: center;
    }
    .checkout-container {
        padding: 60px 0;
        background: white;
    }
    .checkout-form {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: var(--shadow);
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--text-dark);
    }
    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        font-size: 1rem;
    }
    .payment-method {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.3s;
    }
    .payment-method:hover {
        border-color: var(--primary-color);
        background: var(--bg-light-pink);
    }
    .payment-method input[type="radio"] {
        margin-right: 10px;
    }
    .order-summary {
        background: var(--bg-light-pink);
        padding: 30px;
        border-radius: 15px;
        box-shadow: var(--shadow);
        position: sticky;
        top: 140px;
    }
    .order-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border-color);
    }
</style>
@endsection

@section('content')

    <!-- Checkout Header -->
    <div class="checkout-header">
        <h1>Checkout</h1>
        <p>Complete your order</p>
    </div>

    <!-- Checkout Content -->
    <section class="checkout-container">
        <div class="container">
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
                    <!-- Checkout Form -->
                    <div>
                        <div class="checkout-form">
                            <h3 style="margin-bottom: 25px;">Shipping Information</h3>
                            
                            <div class="form-group">
                                <label for="full_name">Full Name</label>
                                <input type="text" id="full_name" name="full_name" value="{{ auth()->user()->name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" value="{{ auth()->user()->phone ?? '' }}" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" required>
                            </div>

                            <div class="form-group">
                                <label for="shipping_address">Shipping Address</label>
                                <textarea id="shipping_address" name="shipping_address" rows="3" required placeholder="Street address, apartment, suite, etc."></textarea>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" id="city" name="city" required>
                                </div>

                                <div class="form-group">
                                    <label for="postal_code">Postal Code</label>
                                    <input type="text" id="postal_code" name="postal_code">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="notes">Order Notes (Optional)</label>
                                <textarea id="notes" name="notes" rows="3" placeholder="Special instructions for your order"></textarea>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="checkout-form" style="margin-top: 30px;">
                            <h3 style="margin-bottom: 25px;">Payment Method</h3>
                            
                            <label class="payment-method">
                                <input type="radio" name="payment_method" value="cod" checked>
                                <div style="flex: 1;">
                                    <strong>Cash on Delivery</strong>
                                    <p style="color: var(--text-gray); font-size: 0.9rem; margin: 5px 0 0 0;">Pay when you receive your order</p>
                                </div>
                            </label>

                            <label class="payment-method">
                                <input type="radio" name="payment_method" value="payhere">
                                <div style="flex: 1;">
                                    <strong>PayHere</strong>
                                    <p style="color: var(--text-gray); font-size: 0.9rem; margin: 5px 0 0 0;">Pay securely online with PayHere</p>
                                </div>
                            </label>

                            <label class="payment-method">
                                <input type="radio" name="payment_method" value="bank">
                                <div style="flex: 1;">
                                    <strong>Bank Transfer</strong>
                                    <p style="color: var(--text-gray); font-size: 0.9rem; margin: 5px 0 0 0;">Transfer directly to our bank account</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div>
                        <div class="order-summary">
                            <h3 style="margin-bottom: 20px;">Order Summary</h3>
                            
                            <div style="max-height: 300px; overflow-y: auto; margin-bottom: 20px;">
                                @foreach($cartItems as $item)
                                    <div class="order-item">
                                        <div style="flex: 1;">
                                            <h4 style="font-size: 0.95rem; margin-bottom: 5px;">{{ $item->product->name }}</h4>
                                            <p style="color: var(--text-gray); font-size: 0.85rem;">Qty: {{ $item->quantity }}</p>
                                        </div>
                                        <strong>Rs. {{ number_format($item->product->price * $item->quantity, 2) }}</strong>
                                    </div>
                                @endforeach
                            </div>

                            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                                <span>Subtotal</span>
                                <strong>Rs. {{ number_format($total, 2) }}</strong>
                            </div>

                            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                                <span>Shipping</span>
                                <strong>Rs. 300.00</strong>
                            </div>

                            <hr style="margin: 20px 0; border: none; border-top: 2px solid var(--border-color);">

                            <div style="display: flex; justify-content: space-between; margin-bottom: 30px; font-size: 1.2rem;">
                                <strong>Total</strong>
                                <strong style="color: var(--primary-color);">Rs. {{ number_format($total + 300, 2) }}</strong>
                            </div>

                            <button type="submit" class="btn-primary" style="width: 100%;">Place Order</button>
                            <a href="{{ route('cart.index') }}" style="display: block; text-align: center; margin-top: 15px; color: var(--text-gray);">
                                <i class="fas fa-arrow-left"></i> Back to Cart
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection
