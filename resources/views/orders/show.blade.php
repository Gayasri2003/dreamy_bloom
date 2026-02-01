@extends('layouts.modern')

@section('title', 'Order Details - DreamyBloom')

@section('styles')
<style>
    .order-details-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 60px 20px;
        min-height: 60vh;
    }
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 30px;
        transition: all 0.3s;
    }
    .back-link:hover {
        gap: 12px;
    }
    .order-details-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 30px;
        border-radius: 15px 15px 0 0;
        margin-bottom: 0;
    }
    .order-details-header h1 {
        font-size: 1.8rem;
        margin-bottom: 10px;
    }
    .order-meta {
        display: flex;
        gap: 30px;
        flex-wrap: wrap;
        font-size: 0.95rem;
        opacity: 0.95;
    }
    .details-card {
        background: white;
        border-radius: 0 0 15px 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .details-section {
        padding: 30px;
        border-bottom: 2px solid var(--border-color);
    }
    .details-section:last-child {
        border-bottom: none;
    }
    .section-title {
        font-size: 1.3rem;
        color: var(--primary-color);
        margin-bottom: 20px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }
    .info-item {
        background: var(--bg-light-pink);
        padding: 20px;
        border-radius: 10px;
    }
    .info-label {
        font-size: 0.85rem;
        color: var(--text-gray);
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-value {
        font-size: 1.1rem;
        color: var(--text-dark);
        font-weight: 600;
    }
    .status-badge {
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 700;
        display: inline-block;
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
    .payment-paid {
        background: #d4edda;
        color: #155724;
    }
    .payment-pending {
        background: #fff3cd;
        color: #856404;
    }
    .items-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
    }
    .items-table thead th {
        background: var(--bg-pink);
        padding: 15px;
        text-align: left;
        color: var(--primary-color);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    .items-table thead th:first-child {
        border-radius: 10px 0 0 10px;
    }
    .items-table thead th:last-child {
        border-radius: 0 10px 10px 0;
    }
    .items-table tbody tr {
        background: var(--bg-light-pink);
    }
    .items-table tbody td {
        padding: 20px 15px;
    }
    .items-table tbody tr td:first-child {
        border-radius: 10px 0 0 10px;
    }
    .items-table tbody tr td:last-child {
        border-radius: 0 10px 10px 0;
    }
    .product-cell {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .product-image {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 10px;
        flex-shrink: 0;
    }
    .product-info h4 {
        color: var(--text-dark);
        font-weight: 600;
        margin-bottom: 5px;
    }
    .product-info p {
        color: var(--text-gray);
        font-size: 0.9rem;
    }
    .total-section {
        background: linear-gradient(135deg, var(--bg-pink) 0%, var(--bg-light-pink) 100%);
        padding: 30px;
        border-radius: 10px;
        margin-top: 20px;
    }
    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid rgba(155, 93, 143, 0.2);
    }
    .total-row:last-child {
        border-bottom: none;
        padding-top: 20px;
        margin-top: 10px;
        border-top: 3px solid var(--primary-color);
    }
    .total-label {
        font-size: 1.1rem;
        color: var(--text-dark);
        font-weight: 600;
    }
    .total-value {
        font-size: 1.1rem;
        color: var(--primary-color);
        font-weight: 700;
    }
    .grand-total .total-label {
        font-size: 1.5rem;
        color: var(--primary-color);
    }
    .grand-total .total-value {
        font-size: 1.8rem;
    }
    @media (max-width: 768px) {
        .order-meta {
            flex-direction: column;
            gap: 10px;
        }
        .info-grid {
            grid-template-columns: 1fr;
        }
        .items-table {
            font-size: 0.9rem;
        }
        .product-cell {
            flex-direction: column;
            text-align: center;
        }
        .items-table thead {
            display: none;
        }
        .items-table tbody td {
            display: block;
            text-align: left;
            padding: 10px;
        }
        .items-table tbody tr {
            display: block;
            margin-bottom: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="order-details-container">
    <a href="{{ route('orders.index') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Orders
    </a>

    <div class="order-details-header">
        <h1><i class="fas fa-receipt"></i> Order #{{ $order->id }}</h1>
        <div class="order-meta">
            <span><i class="far fa-calendar-alt"></i> Placed on {{ $order->created_at->format('M d, Y') }}</span>
            <span><i class="far fa-clock"></i> {{ $order->created_at->format('h:i A') }}</span>
            <span><i class="fas fa-hashtag"></i> Order ID: {{ $order->id }}</span>
        </div>
    </div>

    <div class="details-card">
        <!-- Order Status Section -->
        <div class="details-section">
            <h2 class="section-title">
                <i class="fas fa-info-circle"></i> Order Status
            </h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Order Status</div>
                    <div class="info-value">
                        <span class="status-badge status-{{ $order->status }}">
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
                <div class="info-item">
                    <div class="info-label">Payment Status</div>
                    <div class="info-value">
                        <span class="status-badge payment-{{ $order->payment_status }}">
                            @if($order->payment_status === 'paid')
                                <i class="fas fa-check-circle"></i> Paid
                            @else
                                <i class="fas fa-clock"></i> Pending
                            @endif
                        </span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Payment Method</div>
                    <div class="info-value">
                        <i class="fas fa-credit-card"></i> {{ ucfirst($order->payment_method ?? 'N/A') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer & Shipping Info -->
        <div class="details-section">
            <h2 class="section-title">
                <i class="fas fa-user"></i> Customer & Shipping Information
            </h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Customer Name</div>
                    <div class="info-value">{{ $order->user->name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $order->user->email }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Phone</div>
                    <div class="info-value">{{ $order->user->phone ?? 'N/A' }}</div>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <div class="info-label">Shipping Address</div>
                    <div class="info-value">
                        <i class="fas fa-map-marker-alt"></i> {{ $order->shipping_address }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="details-section">
            <h2 class="section-title">
                <i class="fas fa-shopping-bag"></i> Order Items
            </h2>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div class="product-cell">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="product-image">
                                @else
                                    <div class="product-image" style="background: var(--border-color); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-image" style="color: var(--text-gray);"></i>
                                    </div>
                                @endif
                                <div class="product-info">
                                    <h4>{{ $item->product->name ?? 'Product Deleted' }}</h4>
                                    @if($item->product)
                                        <p>{{ Str::limit($item->product->description, 50) }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td><strong>Rs. {{ number_format($item->price, 2) }}</strong></td>
                        <td>{{ $item->quantity }}</td>
                        <td><strong style="color: var(--primary-color);">Rs. {{ number_format($item->price * $item->quantity, 2) }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total-section">
                <div class="total-row">
                    <span class="total-label">Subtotal</span>
                    <span class="total-value">Rs. {{ number_format($order->items->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</span>
                </div>
                <div class="total-row">
                    <span class="total-label">Shipping</span>
                    <span class="total-value">Free</span>
                </div>
                <div class="total-row grand-total">
                    <span class="total-label">Grand Total</span>
                    <span class="total-value">Rs. {{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        @if($order->notes)
        <div class="details-section">
            <h2 class="section-title">
                <i class="fas fa-sticky-note"></i> Order Notes
            </h2>
            <div class="info-item">
                <p style="color: var(--text-dark); line-height: 1.6;">{{ $order->notes }}</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
