@extends('admin.layout')

@section('title', 'Create Product')
@section('page-title', 'Create New Product')

@section('content')
<div class="card" style="margin-bottom: 2rem;">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-plus-circle"></i>
            Add New Product
        </h2>
        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>
    </div>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Left Column - Main Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i>
                    Product Information
                </h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-tag" style="color: var(--admin-primary); margin-right: 0.5rem;"></i>
                        Product Name *
                    </label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter product name" required>
                    @error('name')<div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-align-left" style="color: var(--admin-primary); margin-right: 0.5rem;"></i>
                        Description
                    </label>
                    <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror" placeholder="Enter product description">{{ old('description') }}</textarea>
                    @error('description')<div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>@enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-folder" style="color: var(--admin-primary); margin-right: 0.5rem;"></i>
                            Category *
                        </label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-boxes" style="color: var(--admin-primary); margin-right: 0.5rem;"></i>
                            Stock Quantity *
                        </label>
                        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', 0) }}" min="0" placeholder="0" required>
                        @error('stock')<div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-dollar-sign" style="color: var(--success); margin-right: 0.5rem;"></i>
                            Price *
                        </label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary); font-weight: 600;">Rs.</span>
                            <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="0.00" style="padding-left: 2rem;" required>
                        </div>
                        @error('price')<div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-percentage" style="color: var(--warning); margin-right: 0.5rem;"></i>
                            Old Price (Optional)
                        </label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary); font-weight: 600;">Rs.</span>
                            <input type="number" step="0.01" name="old_price" class="form-control @error('old_price') is-invalid @enderror" value="{{ old('old_price') }}" placeholder="0.00" style="padding-left: 2rem;">
                        </div>
                        @error('old_price')<div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Settings -->
        <div>
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-image"></i>
                        Product Image
                    </h3>
                </div>
                <div class="card-body">
                    <div class="form-group" style="margin-bottom: 0;">
                        <div style="border: 2px dashed var(--border); border-radius: 12px; padding: 2rem; text-align: center; background: #fafafa; transition: all 0.3s;" onmouseover="this.style.borderColor='var(--admin-primary)'; this.style.background='#f8f9ff';" onmouseout="this.style.borderColor='var(--border)'; this.style.background='#fafafa';">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 3rem; color: var(--admin-primary); margin-bottom: 1rem;"></i>
                            <div style="margin-bottom: 1rem; color: var(--text-secondary);">
                                <strong>Click to upload</strong> or drag and drop
                            </div>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" style="cursor: pointer;">
                            <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.5rem;">
                                PNG, JPG, GIF up to 10MB
                            </div>
                        </div>
                        @error('image')<div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cog"></i>
                        Settings
                    </h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background: #f8fafc; border-radius: 10px;">
                            <div>
                                <div style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem;">
                                    <i class="fas fa-check-circle" style="color: var(--success); margin-right: 0.5rem;"></i>
                                    Active Status
                                </div>
                                <div style="font-size: 0.75rem; color: var(--text-secondary);">Make product visible to customers</div>
                            </div>
                            <label style="position: relative; display: inline-block; width: 50px; height: 26px; margin: 0;">
                                <input type="checkbox" name="is_active" id="is_active" {{ old('is_active', true) ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0;">
                                <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 26px;"></span>
                            </label>
                        </div>

                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background: #f8fafc; border-radius: 10px;">
                            <div>
                                <div style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem;">
                                    <i class="fas fa-star" style="color: var(--warning); margin-right: 0.5rem;"></i>
                                    New Arrival
                                </div>
                                <div style="font-size: 0.75rem; color: var(--text-secondary);">Show "New" badge on product</div>
                            </div>
                            <label style="position: relative; display: inline-block; width: 50px; height: 26px; margin: 0;">
                                <input type="checkbox" name="is_new" id="is_new" {{ old('is_new') ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0;">
                                <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 26px;"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="card" style="margin-top: 2rem;">
        <div class="card-body" style="display: flex; justify-content: flex-end; gap: 1rem; padding: 1.5rem;">
            <a href="{{ route('admin.products.index') }}" class="btn" style="background: #f1f5f9; color: var(--text-primary); border: 2px solid var(--border);">
                <i class="fas fa-times"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create Product
            </button>
        </div>
    </div>
</form>

@section('styles')
<style>
/* Toggle Switch */
input[type="checkbox"]:checked + span {
    background-color: var(--admin-primary);
}
input[type="checkbox"]:checked + span:before {
    transform: translateX(24px);
}
input[type="checkbox"] + span:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

@media (max-width: 768px) {
    div[style*="grid-template-columns: 2fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection

@endsection
