@extends('layouts.modern')

@section('title', 'My Orders - DreamyBloom')

@section('styles')
<style>
    .orders-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 60px 20px;
        min-height: 60vh;
    }
    .orders-header {
        text-align: center;
        margin-bottom: 50px;
    }
    .orders-header h1 {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 10px;
    }
    .orders-header p {
        color: var(--text-gray);
        font-size: 1.1rem;
    }
    .empty-orders {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    .empty-orders i {
        font-size: 5rem;
        color: var(--primary-color);
        opacity: 0.3;
        margin-bottom: 20px;
    }
    .empty-orders h3 {
        color: var(--text-dark);
        margin-bottom: 10px;
        font-size: 1.5rem;
    }
    .empty-orders p {
        color: var(--text-gray);
        margin-bottom: 30px;
    }
    .empty-orders a {
        display: inline-block;
        padding: 15px 40px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .empty-orders a:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(155, 93, 143, 0.3);
    }
    .order-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        margin-bottom: 25px;
        overflow: hidden;
        transition: all 0.3s;
    }
    .order-card:hover {
        box-shadow: 0 6px 25px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }
    .order-header {
        background: linear-gradient(135deg, var(--bg-pink) 0%, var(--bg-light-pink) 100%);
        padding: 20px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .order-id {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1.1rem;
    }
    .order-date {
        color: var(--text-gray);
        font-size: 0.9rem;
    }
    .order-status {
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: capitalize;
    }
    .status-pending {
        background: #fff3cd;
        color: #856404;
    }
    .status-processing {
        background: #d1ecf1;
        color: #0c5460;
    }
    .status-completed {
        background: #d4edda;
        color: #155724;
    }
    .status-cancelled {
        background: #f8d7da;
        color: #721c24;
    }
    .order-body {
        padding: 25px 30px;
    }
    .order-items {
        margin-bottom: 20px;
    }
    .order-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: var(--bg-light-pink);
        border-radius: 10px;
        margin-bottom: 10px;
    }
    .order-item:last-child {
        margin-bottom: 0;
    }
    .item-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        flex-shrink: 0;
    }
    .item-details {
        flex: 1;
    }
    .item-name {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 5px;
    }
    .item-quantity {
        color: var(--text-gray);
        font-size: 0.9rem;
    }
    .item-price {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1.1rem;
    }
    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 20px;
        border-top: 2px solid var(--border-color);
        flex-wrap: wrap;
        gap: 15px;
    }
    .order-total {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-dark);
    }
    .order-total span {
        color: var(--primary-color);
    }
    .view-details-btn {
        padding: 12px 30px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .view-details-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(155, 93, 143, 0.3);
    }
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 40px;
    }
    .pagination a,
    .pagination span {
        padding: 10px 15px;
        border-radius: 8px;
        color: var(--text-dark);
        text-decoration: none;
        transition: all 0.3s;
    }
    .pagination a:hover {
        background: var(--primary-color);
        color: white;
    }
    .pagination .active {
        background: var(--primary-color);
        color: white;
    }
    .order-payment {
        display: flex;
        gap: 20px;
        margin-top: 15px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 10px;
    }
    .payment-info {
        flex: 1;
    }
    .payment-label {
        font-size: 0.85rem;
        color: var(--text-gray);
        margin-bottom: 5px;
    }
    .payment-value {
        font-weight: 600;
        color: var(--text-dark);
    }
    @media (max-width: 768px) {
        .orders-header h1 {
            font-size: 2rem;
        }
        .order-header {
            padding: 15px 20px;
        }
        .order-body {
            padding: 20px 15px;
        }
        .order-item {
            flex-direction: column;
            text-align: center;
        }
        .order-footer {
            flex-direction: column;
        }
        .order-payment {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<div class="orders-container">
    <div class="orders-header">
        <h1><i class="fas fa-box"></i> My Orders</h1>
        <p>Track and manage your orders</p>
    </div>

    @if($orders->isEmpty())
        <div class="empty-orders">
            <i class="fas fa-shopping-bag"></i>
            <h3>No Orders Yet</h3>
            <p>You haven't placed any orders yet. Start shopping to see your orders here!</p>
            <a href="{{ route('shop.products') }}">
                Start Shopping
            </a>
        </div>
    @else
        @foreach($orders as $order)
        <div class="order-card">
            <div class="order-header">
                <div>
                    <div class="order-id">
                        <i class="fas fa-receipt"></i> Order #{{ $order->id }}
                    </div>
                    <div class="order-date">
                        <i class="far fa-calendar-alt"></i> {{ $order->created_at->format('M d, Y - h:i A') }}
                    </div>
                </div>
                <div>
                    <span class="order-status status-{{ $order->status }}">
                        @if($order->status === 'pending')
                            <i class="fas fa-clock"></i> Pending
                        @elseif($order->status === 'processing')
                            <i class="fas fa-cog fa-spin"></i> Processing
                        @elseif($order->status === 'completed')
                            <i class="fas fa-check-circle"></i> Completed
                        @else
                            <i class="fas fa-times-circle"></i> Cancelled
                        @endif
                    </span>
                </div>
            </div>

            <div class="order-body">
                <div class="order-items">
                    @foreach($order->items->take(3) as $item)
                    <div class="order-item">
                        @if($item->product && $item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="item-image">
                        @else
                            <div class="item-image" style="background: var(--border-color); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image" style="color: var(--text-gray);"></i>
                            </div>
                        @endif
                        <div class="item-details">
                            <div class="item-name">{{ $item->product->name ?? 'Product Deleted' }}</div>
                            <div class="item-quantity">
                                <i class="fas fa-boxes"></i> Quantity: {{ $item->quantity }}
                            </div>
                        </div>
                        <div class="item-price">
                            Rs. {{ number_format($item->price * $item->quantity, 2) }}
                        </div>
                    </div>
                    @endforeach

                    @if($order->items->count() > 3)
                    <div style="text-align: center; color: var(--text-gray); padding: 10px; font-size: 0.9rem;">
                        <i class="fas fa-ellipsis-h"></i> And {{ $order->items->count() - 3 }} more items
                    </div>
                    @endif
                </div>

                <div class="order-payment">
                    <div class="payment-info">
                        <div class="payment-label">Payment Method</div>
                        <div class="payment-value">
                            <i class="fas fa-credit-card"></i> {{ ucfirst($order->payment_method ?? 'N/A') }}
                        </div>
                    </div>
                    <div class="payment-info">
                        <div class="payment-label">Payment Status</div>
                        <div class="payment-value">
                            @if($order->payment_status === 'paid')
                                <i class="fas fa-check-circle" style="color: #28a745;"></i> Paid
                            @else
                                <i class="fas fa-clock" style="color: #ffc107;"></i> Pending
                            @endif
                        </div>
                    </div>
                    <div class="payment-info">
                        <div class="payment-label">Shipping Address</div>
                        <div class="payment-value">
                            <i class="fas fa-map-marker-alt"></i> {{ Str::limit($order->shipping_address, 30) }}
                        </div>
                    </div>
                </div>

                <div class="order-footer">
                    <div class="order-total">
                        Total: <span>Rs. {{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    <a href="{{ route('orders.show', $order->id) }}" class="view-details-btn">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                </div>
            </div>
        </div>
        @endforeach

        <div class="pagination">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
