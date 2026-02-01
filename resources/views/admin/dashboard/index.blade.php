@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-icon-primary">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['total_products'] }}</h3>
                <p>Total Products</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon stat-icon-success">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['total_orders'] }}</h3>
                <p>Total Orders</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon stat-icon-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['pending_orders'] }}</h3>
                <p>Pending Orders</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon stat-icon-danger">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <h3>Rs. {{ number_format($stats['total_revenue'], 2) }}</h3>
                <p>Total Revenue</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['total_users'] }}</h3>
                <p>Total Customers</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-success">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['total_categories'] }}</h3>
                <p>Categories</p>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div style="margin-top: 40px;">
        <div style="background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 30px;">
            <h3 style="margin-bottom: 20px;">Recent Orders</h3>
            @if($stats['recent_orders']->count() > 0)
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border-color);">
                            <th style="padding: 15px; text-align: left;">Order ID</th>
                            <th style="padding: 15px; text-align: left;">Customer</th>
                            <th style="padding: 15px; text-align: left;">Amount</th>
                            <th style="padding: 15px; text-align: left;">Status</th>
                            <th style="padding: 15px; text-align: left;">Date</th>
                            <th style="padding: 15px; text-align: left;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['recent_orders'] as $order)
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 15px;">#{{ $order->id }}</td>
                                <td style="padding: 15px;">{{ $order->user->name }}</td>
                                <td style="padding: 15px;">Rs. {{ number_format($order->total_amount, 2) }}</td>
                                <td style="padding: 15px;">
                                    <span class="status-badge status-{{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td style="padding: 15px;">{{ $order->created_at->format('M d, Y') }}</td>
                                <td style="padding: 15px;">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" style="color: var(--primary-color);">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: var(--text-gray); padding: 40px;">No orders yet</p>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 40px;">
        <a href="{{ route('admin.products.create') }}" style="background: white; padding: 30px; border-radius: 15px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05); text-decoration: none; color: inherit; transition: transform 0.3s;">
            <i class="fas fa-plus-circle" style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: 15px;"></i>
            <h4>Add New Product</h4>
        </a>
        <a href="{{ route('admin.categories.create') }}" style="background: white; padding: 30px; border-radius: 15px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05); text-decoration: none; color: inherit; transition: transform 0.3s;">
            <i class="fas fa-tag" style="font-size: 2.5rem; color: #28a745; margin-bottom: 15px;"></i>
            <h4>Add Category</h4>
        </a>
        <a href="{{ route('admin.orders.index') }}" style="background: white; padding: 30px; border-radius: 15px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05); text-decoration: none; color: inherit; transition: transform 0.3s;">
            <i class="fas fa-list" style="font-size: 2.5rem; color: #ffc107; margin-bottom: 15px;"></i>
            <h4>View All Orders</h4>
        </a>
        <a href="{{ route('admin.users.index') }}" style="background: white; padding: 30px; border-radius: 15px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05); text-decoration: none; color: inherit; transition: transform 0.3s;">
            <i class="fas fa-users" style="font-size: 2.5rem; color: #17a2b8; margin-bottom: 15px;"></i>
            <h4>Manage Users</h4>
        </a>
    </div>

@endsection

@section('styles')
<style>
    .status-badge {
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    .status-pending {
        background: #fff3cd;
        color: #856404;
    }
    .status-processing {
        background: #cfe2ff;
        color: #084298;
    }
    .status-shipped {
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
</style>
@endsection
