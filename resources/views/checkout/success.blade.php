@extends('layouts.modern')

@section('title', 'Order Success')

@section('content')
<section class="page-header">
    <div class="container">
        <h1>Order Success</h1>
        <div class="breadcrumb">
            <a href="{{ route('shop.home') }}">Home</a>
            <span>/</span>
            <a href="{{ route('cart.index') }}">Cart</a>
            <span>/</span>
            <span>Order Success</span>
        </div>
    </div>
</section>

<section class="order-success-section" style="padding: 60px 0; background: var(--bg-light-pink);">
    <div class="container" style="max-width: 800px; margin: 0 auto;">
        <div style="background: var(--white); border-radius: 20px; padding: 50px; text-align: center; box-shadow: 0 8px 30px rgba(155, 93, 143, 0.15);">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%); border-radius: 50%; margin: 0 auto 30px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(34, 197, 94, 0.3);">
                <i class="fas fa-check" style="font-size: 40px; color: white;"></i>
            </div>
            
            <h1 style="color: var(--primary-color); margin-bottom: 15px; font-size: 2rem;">Order Placed Successfully!</h1>
            <p style="color: var(--text-gray); font-size: 1.1rem; margin-bottom: 40px;">Thank you for your order. We'll process it shortly and send you updates via email.</p>
            
            <div style="background: var(--bg-pink); border-radius: 15px; padding: 30px; text-align: left; margin-bottom: 30px;">
                <h3 style="color: var(--primary-color); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-receipt"></i> Order Details
                </h3>
                
                <div style="display: grid; gap: 15px;">
                    <div style="display: flex; justify-content: space-between; padding-bottom: 10px; border-bottom: 1px solid var(--border-color);">
                        <span style="color: var(--text-gray); font-weight: 500;">Order Number:</span>
                        <span style="color: var(--primary-color); font-weight: 700;">{{ $order->order_number }}</span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; padding-bottom: 10px; border-bottom: 1px solid var(--border-color);">
                        <span style="color: var(--text-gray); font-weight: 500;">Total Amount:</span>
                        <span style="color: var(--primary-color); font-weight: 700; font-size: 1.2rem;">Rs. {{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; padding-bottom: 10px; border-bottom: 1px solid var(--border-color);">
                        <span style="color: var(--text-gray); font-weight: 500;">Payment Method:</span>
                        <span style="color: var(--text-dark); font-weight: 600;">{{ ucfirst($order->payment_method) }}</span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; padding-bottom: 10px; border-bottom: 1px solid var(--border-color);">
                        <span style="color: var(--text-gray); font-weight: 500;">Status:</span>
                        <span style="padding: 5px 15px; background: #FEF3C7; color: #D97706; border-radius: 20px; font-weight: 600; font-size: 0.9rem;">{{ ucfirst($order->status) }}</span>
                    </div>
                    
                    @if($order->payment_method === 'payhere')
                        <div style="display: flex; justify-content: space-between; padding-bottom: 10px; border-bottom: 1px solid var(--border-color);">
                            <span style="color: var(--text-gray); font-weight: 500;">Payment Status:</span>
                            <span style="padding: 5px 15px; background: {{ $order->payment_status === 'paid' ? '#D1FAE5' : '#FEF3C7' }}; color: {{ $order->payment_status === 'paid' ? '#059669' : '#D97706' }}; border-radius: 20px; font-weight: 600; font-size: 0.9rem;">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        @if($order->payment_id)
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: var(--text-gray); font-weight: 500;">Transaction ID:</span>
                                <span style="color: var(--text-dark); font-family: monospace; font-size: 0.9rem;">{{ $order->payment_id }}</span>
                            </div>
                        @endif
                    @endif
                </div>
                
                <h4 style="color: var(--primary-color); margin-top: 30px; margin-bottom: 15px;">Order Items:</h4>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @foreach($order->items as $item)
                        <div style="display: flex; justify-content: space-between; padding: 10px; background: var(--white); border-radius: 8px;">
                            <span style="color: var(--text-dark);">{{ $item->product->name }} <span style="color: var(--text-gray);">(×{{ $item->quantity }})</span></span>
                            <span style="color: var(--primary-color); font-weight: 600;">Rs. {{ number_format($item->price * $item->quantity, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('shop.home') }}" class="btn-primary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-home"></i> Continue Shopping
                </a>
                <a href="{{ route('shop.products') }}" class="btn-cart" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-shopping-bag"></i> Browse Products
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
