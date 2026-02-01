@extends('admin.layout')

@section('title', 'Orders')
@section('page-title', 'Orders Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-shopping-bag"></i>
            All Orders
        </h2>
        <form action="{{ route('admin.orders.index') }}" method="GET" style="margin: 0;">
            <select name="status" class="form-control" style="width: 160px; padding: 0.75rem; font-size: 0.875rem;" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </form>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                <span style="font-weight: 700; color: var(--admin-primary); font-size: 1rem;">#{{ $order->order_number }}</span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #3b82f6, #06b6d4); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                        {{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: var(--text-primary);">{{ $order->user->name ?? 'Guest' }}</div>
                                        <div style="font-size: 0.75rem; color: var(--text-secondary);">{{ $order->user->email ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 0.875rem;">
                                    <div style="font-weight: 600; color: var(--text-primary);">{{ $order->created_at->format('M d, Y') }}</div>
                                    <div style="color: var(--text-secondary); font-size: 0.75rem;">{{ $order->created_at->format('h:i A') }}</div>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: var(--success); font-size: 1.1rem;">${{ number_format($order->total_amount, 2) }}</div>
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                    <span class="badge badge-primary">{{ ucfirst($order->payment_method) }}</span>
                                    <span class="badge badge-{{ 
                                        $order->payment_status === 'paid' ? 'success' : 
                                        ($order->payment_status === 'pending' ? 'warning' : 
                                        ($order->payment_status === 'failed' ? 'danger' : 'info')) 
                                    }}">{{ ucfirst($order->payment_status) }}</span>
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('admin.orders.update', $order) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-control" style="width: 140px; padding: 0.5rem; font-size: 0.8rem; font-weight: 600; background: {{ 
                                        $order->status === 'completed' ? '#dcfce7' : 
                                        ($order->status === 'pending' ? '#fef3c7' : 
                                        ($order->status === 'cancelled' ? '#fee2e2' : '#dbeafe')) 
                                    }}; color: {{ 
                                        $order->status === 'completed' ? '#166534' : 
                                        ($order->status === 'pending' ? '#92400e' : 
                                        ($order->status === 'cancelled' ? '#991b1b' : '#1e40af')) 
                                    }}; border: 2px solid {{ 
                                        $order->status === 'completed' ? '#86efac' : 
                                        ($order->status === 'pending' ? '#fde047' : 
                                        ($order->status === 'cancelled' ? '#fca5a5' : '#93c5fd')) 
                                    }};" onchange="this.form.submit()">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="action-btn action-btn-view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $orders->links() }}
    </div>
</div>
@endsection
