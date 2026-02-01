@extends('admin.layout')

@section('title', 'Products')
@section('page-title', 'Products Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-box"></i>
            All Products
        </h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Product
        </a>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <span style="font-weight: 600; color: var(--admin-primary);">#{{ $product->id }}</span>
                            </td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 60px; height: 60px; border-radius: 10px; object-fit: cover; box-shadow: var(--shadow);">
                                @else
                                    <div style="width: 60px; height: 60px; border-radius: 10px; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); display: flex; align-items: center; justify-content: center; color: var(--text-secondary);">
                                        <i class="fas fa-box"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div style="max-width: 250px;">
                                    <div style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem;">{{ $product->name }}</div>
                                    <small style="color: var(--text-secondary); font-size: 0.8rem;">{{ Str::limit($product->description, 50) }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-primary">{{ $product->category->name }}</span>
                            </td>
                            <td>
                            <div style="font-weight: 700; color: var(--success); font-size: 1rem;">
                                Rs. {{ number_format($product->price, 2) }}
                            </div>

                            @if($product->old_price)
                                <small style="text-decoration: line-through; color: var(--text-secondary); font-size: 0.75rem;">
                                    Rs. {{ number_format($product->old_price, 2) }}
                                </small>
                            @endif
                        </td>

                            <td>
                                <span class="badge badge-{{ $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }}">
                                    {{ $product->stock }} Units
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                    <span class="badge badge-{{ $product->is_active ? 'success' : 'danger' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    @if($product->is_new)
                                        <span class="badge badge-info">New Arrival</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="action-btn action-btn-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="margin: 0; display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn action-btn-delete" onclick="return confirm('Delete this product?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No products found. <a href="{{ route('admin.products.create') }}">Add your first product</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $products->links() }}
    </div>
</div>
@endsection
