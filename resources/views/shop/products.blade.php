@extends('layouts.modern')

@section('title', 'Products - DreamyBloom')

@section('styles')
<style>
    .page-hero {
        background: linear-gradient(135deg, rgba(155, 93, 143, 0.9), rgba(220, 145, 198, 0.9)), url('{{ asset('img/home_image.jpeg') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        padding: 120px 0;
        text-align: center;
        position: relative;
    }
    .page-hero h1 {
        font-size: 3.5rem;
        color: white;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    .page-hero p {
        color: white;
        font-size: 1.2rem;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    }
    .filter-section {
        background: white;
        padding: 30px 0;
        box-shadow: var(--shadow);
        margin-bottom: 40px;
    }
    .filter-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        flex-wrap: wrap;
        gap: 15px;
    }
    .filter-tags {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .filter-tag {
        padding: 8px 20px;
        background: var(--bg-pink);
        border: 2px solid var(--primary-color);
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 500;
        text-decoration: none;
        color: var(--text-dark);
    }
    .filter-tag:hover,
    .filter-tag.active {
        background: var(--primary-color);
        color: white;
    }
    .sort-dropdown {
        padding: 12px 20px;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        font-size: 0.95rem;
        cursor: pointer;
        background: white;
        color: var(--text-dark);
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        transition: all 0.3s;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239B5D8F' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        padding-right: 45px;
    }
    .sort-dropdown:hover {
        border-color: var(--primary-color);
        box-shadow: 0 4px 12px rgba(155, 93, 143, 0.2);
    }
    .sort-dropdown:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(155, 93, 143, 0.1);
    }
    
</style>
@endsection

@section('content')

    <!-- Page Hero -->
    <div class="page-hero">
        <h1>Our Products</h1>
        <p>Discover premium beauty and skincare essentials</p>
    </div>

    <!-- Filter Section -->
    <section class="filter-section">
        <div class="filter-container">
            <div class="filter-tags">
                <a href="{{ route('shop.products') }}" class="filter-tag {{ !request('category') ? 'active' : '' }}">All Products</a>
                @foreach($categories as $cat)
                    <a href="{{ route('shop.products', ['category' => $cat->slug]) }}" class="filter-tag {{ request('category') == $cat->slug ? 'active' : '' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
            <div>
                <select class="sort-dropdown" onchange="window.location.href = this.value">
                    <option value="{{ route('shop.products', array_merge(request()->except('sort'), ['sort' => 'latest'])) }}" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Latest</option>
                    <option value="{{ route('shop.products', array_merge(request()->except('sort'), ['sort' => 'price_low'])) }}" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="{{ route('shop.products', array_merge(request()->except('sort'), ['sort' => 'price_high'])) }}" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="products-section">
        <div class="container">
            <div class="products-grid">
                @forelse($products as $product)
                    <div class="product-card" onclick="window.location.href='{{ route('shop.product.detail', $product->slug) }}'" style="cursor: pointer;">
                        <div class="product-image">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 300'%3E%3Crect fill='%23F5E6F0' width='300' height='300'/%3E%3Ctext x='50%25' y='50%25' font-size='18' text-anchor='middle' fill='%239B5D8F'%3E{{ $product->name }}%3C/text%3E%3C/svg%3E" alt="{{ $product->name }}">
                            @endif
                        </div>
                        <div class="product-info">
                            <div class="product-category">{{ $product->category->name ?? 'Uncategorized' }}</div>
                            <h3 class="product-title">{{ $product->name }}</h3>
                            <p class="product-description">{{ Str::limit($product->description, 60) }}</p>
                            <div class="product-price" style="margin: 15px 0; font-size: 1.3rem; color: var(--primary-color); font-weight: 700;">Rs. {{ number_format($product->price, 2) }}</div>
                        </div>
                        <div class="product-actions-bottom" style="padding: 0 20px 20px; display: flex; gap: 10px;" onclick="event.stopPropagation();">
                            @auth
                                <form action="{{ route('cart.add') }}" method="POST" style="flex: 1;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-cart" style="width: 100%; padding: 12px; border: none; background: var(--bg-pink); color: var(--primary-color); border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s;">
                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn-cart" style="flex: 1; padding: 12px; border: none; background: var(--bg-pink); color: var(--primary-color); border-radius: 8px; text-decoration: none; font-weight: 600; text-align: center; display: block;">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; grid-column: 1 / -1; padding: 60px 20px;">
                        <h3>No products found</h3>
                        <p>Try adjusting your filters or search criteria</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div style="margin-top: 40px; display: flex; justify-content: center;">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </section>

@endsection

@section('scripts')
<script>
    // Add to cart functionality
    function addToCart(productId) {
        @guest
            openModal('loginModal');
            return;
        @endguest

        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('cart.add') }}';
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
        
        const productInput = document.createElement('input');
        productInput.type = 'hidden';
        productInput.name = 'product_id';
        productInput.value = productId;
        
        const quantityInput = document.createElement('input');
        quantityInput.type = 'hidden';
        quantityInput.name = 'quantity';
        quantityInput.value = 1;
        
        form.appendChild(csrfInput);
        form.appendChild(productInput);
        form.appendChild(quantityInput);
        document.body.appendChild(form);
        form.submit();
    }

    // Wishlist toggle
    function toggleWishlist(productId) {
        alert('Wishlist feature coming soon!');
    }
</script>
@endsection
