@extends('admin.layout')

@section('title', 'Create Category')
@section('page-title', 'Create New Category')

@section('content')
<div class="card" style="margin-bottom: 2rem;">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-plus-circle"></i>
            Add New Category
        </h2>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Back to Categories
        </a>
    </div>
</div>

<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Left Column - Main Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i>
                    Category Information
                </h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-tag" style="color: var(--admin-primary); margin-right: 0.5rem;"></i>
                        Category Name *
                    </label>
                    <input type="text" name="name" id="category-name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter category name" required>
                    <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.5rem;">
                        <i class="fas fa-info-circle"></i> A unique name for the category
                    </div>
                    @error('name')<div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-link" style="color: var(--admin-primary); margin-right: 0.5rem;"></i>
                        Slug *
                    </label>
                    <input type="text" name="slug" id="category-slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="category-slug" required>
                    <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.5rem;">
                        <i class="fas fa-info-circle"></i> URL-friendly version (auto-generated from name, editable)
                    </div>
                    @error('slug')<div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>@enderror
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">
                        <i class="fas fa-align-left" style="color: var(--admin-primary); margin-right: 0.5rem;"></i>
                        Description
                    </label>
                    <textarea name="description" rows="6" class="form-control @error('description') is-invalid @enderror" placeholder="Enter category description (optional)">{{ old('description') }}</textarea>
                    <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.5rem;">
                        <i class="fas fa-info-circle"></i> Brief description of what products belong to this category
                    </div>
                    @error('description')<div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <!-- Right Column - Image & Settings -->
        <div>
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-image"></i>
                        Category Image
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
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 1.25rem; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 12px; border: 2px solid var(--border);">
                        <div>
                            <div style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem; font-size: 1rem;">
                                <i class="fas fa-check-circle" style="color: var(--success); margin-right: 0.5rem;"></i>
                                Active Status
                            </div>
                            <div style="font-size: 0.8rem; color: var(--text-secondary);">Make category visible on website</div>
                        </div>
                        <label style="position: relative; display: inline-block; width: 54px; height: 28px; margin: 0;">
                            <input type="checkbox" name="is_active" id="is_active" {{ old('is_active', true) ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0;">
                            <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .4s; border-radius: 28px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);"></span>
                        </label>
                    </div>
                    
                    <div style="margin-top: 1rem; padding: 1rem; background: #fffbeb; border-left: 4px solid #fbbf24; border-radius: 8px;">
                        <div style="display: flex; gap: 0.75rem;">
                            <i class="fas fa-lightbulb" style="color: #f59e0b; font-size: 1.25rem;"></i>
                            <div>
                                <div style="font-weight: 600; color: #92400e; font-size: 0.875rem; margin-bottom: 0.25rem;">Pro Tip</div>
                                <div style="font-size: 0.8rem; color: #78350f;">Use a square image (500x500px) for best results. Inactive categories won't appear on the website.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="card" style="margin-top: 2rem;">
        <div class="card-body" style="display: flex; justify-content: flex-end; gap: 1rem; padding: 1.5rem;">
            <a href="{{ route('admin.categories.index') }}" class="btn" style="background: #f1f5f9; color: var(--text-primary); border: 2px solid var(--border);">
                <i class="fas fa-times"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create Category
            </button>
        </div>
    </div>
</form>

@section('styles')
<style>
/* Toggle Switch */
input[type="checkbox"]:checked + span {
    background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-accent) 100%);
    box-shadow: 0 4px 12px rgba(124, 58, 237, 0.4);
}
input[type="checkbox"]:checked + span:before {
    transform: translateX(26px);
}
input[type="checkbox"] + span:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

@media (max-width: 768px) {
    div[style*="grid-template-columns: 2fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection

@section('scripts')
<script>
    // Auto-generate slug from category name
    const nameInput = document.getElementById('category-name');
    const slugInput = document.getElementById('category-slug');
    let manualSlugEdit = false;

    slugInput.addEventListener('input', function() {
        manualSlugEdit = true;
    });

    nameInput.addEventListener('input', function() {
        if (!manualSlugEdit) {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
            slugInput.value = slug;
        }
    });
</script>
@endsection

@endsection
