@extends('admin.layout')

@section('title', 'User Details')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2><i class="fas fa-user"></i> {{ $user->name }}</h2>
    </div>
    <div class="col text-end">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Users
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">User Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong><br>{{ $user->name }}</p>
                <p><strong>Email:</strong><br>{{ $user->email }}</p>
                <p><strong>Phone:</strong><br>{{ $user->phone ?? 'N/A' }}</p>
                <p><strong>Address:</strong><br>{{ $user->address ?? 'N/A' }}</p>
                <p><strong>Registered:</strong><br>{{ $user->created_at->format('M d, Y') }}</p>
                <p>
                    <strong>Role:</strong><br>
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="role" class="form-select" onchange="this.form.submit()">
                            <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </form>
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Order History</h5>
            </div>
            <div class="card-body">
                @if($user->orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->orders as $order)
                                    <tr>
                                        <td><a href="{{ route('admin.orders.show', $order) }}">#{{ $order->order_number }}</a></td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>${{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ 
                                                $order->status === 'completed' ? 'success' : 
                                                ($order->status === 'pending' ? 'warning' : 
                                                ($order->status === 'cancelled' ? 'danger' : 'info')) 
                                            }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No orders yet</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
