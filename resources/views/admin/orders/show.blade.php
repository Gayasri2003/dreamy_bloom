@extends('admin.layout')

@section('title', 'Order Details')
@section('page-title', 'Order Details')

@section('content')
<div class="card" style="margin-bottom: 2rem;">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-receipt"></i>
            Order #{{ $order->order_number }}
        </h2>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <!-- Left Column - Order Items -->
    <div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-shopping-cart"></i>
                    Order Items
                </h3>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="modern-table">
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
                                        <div style="font-weight: 600; color: var(--text-primary);">
                                            {{ $item->product->name ?? 'Product Deleted' }}
                                        </div>
                                    </td>
                                    <td>
                                        <span style="color: var(--text-secondary);">${{ number_format($item->price, 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $item->quantity }} x</span>
                                    </td>
                                    <td>
                                        <span style="font-weight: 700; color: var(--success);">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 2px solid var(--border); display: flex; justify-content: flex-end; align-items: center; gap: 1rem;">
                    <span style="font-size: 1.25rem; font-weight: 600; color: var(--text-primary);">Total Amount:</span>
                    <span style="font-size: 2rem; font-weight: 700; color: var(--admin-primary);">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Info Cards -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <!-- Customer Information -->
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, #7c3aed 0%, #ec4899 100%); color: white; border: none;">
                <h3 style="font-size: 1rem; font-weight: 600; margin: 0; color: white;">
                    <i class="fas fa-user"></i> Customer Info
                </h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div>
                        <div style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Name</div>
                        <div style="font-weight: 600; color: var(--text-primary);">{{ $order->user->name ?? 'Guest' }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Email</div>
                        <div style="font-weight: 500; color: var(--text-primary);">{{ $order->user->email ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Phone</div>
                        <div style="font-weight: 500; color: var(--text-primary);">{{ $order->user->phone ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none;">
                <h3 style="font-size: 1rem; font-weight: 600; margin: 0; color: white;">
                    <i class="fas fa-credit-card"></i> Payment Info
                </h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div>
                        <div style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Method</div>
                        <span class="badge badge-primary">{{ ucfirst($order->payment_method ?? 'COD') }}</span>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Status</div>
                        <span class="badge badge-{{ 
                            $order->payment_status === 'paid' ? 'success' : 
                            ($order->payment_status === 'pending' ? 'warning' : 
                            ($order->payment_status === 'failed' ? 'danger' : 'info')) 
                        }}">{{ ucfirst($order->payment_status) }}</span>
                    </div>
                    @if($order->payment_id)
                        <div>
                            <div style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Transaction ID</div>
                            <code style="background: #f1f5f9; padding: 0.5rem; border-radius: 6px; font-size: 0.8rem; display: block;">{{ $order->payment_id }}</code>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Status -->
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border: none;">
                <h3 style="font-size: 1rem; font-weight: 600; margin: 0; color: white;">
                    <i class="fas fa-info-circle"></i> Order Status
                </h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div>
                        <div style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Order Date</div>
                        <div style="font-weight: 500; color: var(--text-primary);">{{ $order->created_at->format('M d, Y h:i A') }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Current Status</div>
                        <form action="{{ route('admin.orders.update', $order) }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-control" style="font-weight: 600;" onchange="this.form.submit()">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏱️ Pending</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>🔄 Processing</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>✅ Completed</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($order->shipping_address)
        <!-- Shipping Address -->
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: white; border: none;">
                <h3 style="font-size: 1rem; font-weight: 600; margin: 0; color: white;">
                    <i class="fas fa-map-marker-alt"></i> Shipping Address
                </h3>
            </div>
            <div class="card-body">
                <p style="margin: 0; color: var(--text-primary); line-height: 1.6;">{{ $order->shipping_address }}</p>
            </div>
        </div>
        @endif
    </div>
</div>

@section('styles')
<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns: 2fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection

@endsection
