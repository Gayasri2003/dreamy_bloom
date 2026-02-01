@extends('admin.layout')

@section('title', 'Categories')
@section('page-title', 'Categories Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-tags"></i>
            All Categories
        </h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Category
        </a>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Slug</th>
                        <th>Products</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                <span style="font-weight: 600; color: var(--admin-primary);">#{{ $category->id }}</span>
                            </td>
                            <td>
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="width: 60px; height: 60px; border-radius: 10px; object-fit: cover; box-shadow: var(--shadow);">
                                @else
                                    <div style="width: 60px; height: 60px; border-radius: 10px; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); display: flex; align-items: center; justify-content: center; color: var(--text-secondary);">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 600; color: var(--text-primary); font-size: 0.95rem;">{{ $category->name }}</div>
                            </td>
                            <td>
                                <code style="background: #f1f5f9; padding: 0.375rem 0.75rem; border-radius: 6px; font-size: 0.8rem; color: var(--admin-primary);">{{ $category->slug }}</code>
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $category->products_count }} Products</span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $category->is_active ? 'success' : 'danger' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="action-btn action-btn-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="margin: 0; display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn action-btn-delete" onclick="return confirm('Delete this category?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No categories found. <a href="{{ route('admin.categories.create') }}">Add your first category</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $categories->links() }}
    </div>
</div>
@endsection
