@extends('layouts.modern')

@section('title', $product->name . ' - DreamyBloom')

@section('styles')
<style>
    .product-detail-container {
        padding: 60px 0;
        background: white;
    }
    .product-image-main {
        width: 100%;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .product-details {
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .price-section {
        background: var(--bg-light-pink);
        padding: 20px;
        border-radius: 10px;
        margin: 20px 0;
    }
    .quantity-selector {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 20px 0;
    }
    .quantity-selector button {
        width: 40px;
        height: 40px;
        border: 2px solid var(--primary-color);
        background: white;
        color: var(--primary-color);
        border-radius: 8px;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s;
    }
    .quantity-selector button:hover {
        background: var(--primary-color);
        color: white;
    }
    .quantity-selector input {
        width: 80px;
        text-align: center;
        padding: 10px;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        font-size: 1rem;
    }
    .product-tabs {
        margin-top: 60px;
    }
    .tab-buttons {
        display: flex;
        gap: 10px;
        border-bottom: 2px solid var(--border-color);
        margin-bottom: 30px;
    }
    .tab-button {
        padding: 15px 30px;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        font-weight: 500;
        color: var(--text-gray);
        transition: all 0.3s;
    }
    .tab-button.active {
        color: var(--primary-color);
        border-bottom-color: var(--primary-color);
    }
</style>
@endsection

@section('content')

    <!-- Product Detail Section -->
    <section class="product-detail-container">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; margin-bottom: 60px;">
                <!-- Product Image -->
                <div>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image-main">
                    @else
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 500 500'%3E%3Crect fill='%23F5E6F0' width='500' height='500'/%3E%3Ctext x='50%25' y='50%25' font-size='24' text-anchor='middle' fill='%239B5D8F'%3E{{ $product->name }}%3C/text%3E%3C/svg%3E" alt="{{ $product->name }}" class="product-image-main">
                    @endif
                </div>

                <!-- Product Details -->
                <div class="product-details">
                    <div style="display: inline-block; padding: 8px 20px; background: var(--bg-pink); color: var(--primary-color); border-radius: 20px; margin-bottom: 20px; font-size: 0.9rem; font-weight: 500;">
                        {{ $product->category->name ?? 'Uncategorized' }}
                    </div>
                    
                    <h1 style="font-size: 2.5rem; margin-bottom: 20px;">{{ $product->name }}</h1>
                    
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                        <div style="color: #ffc107;">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span style="color: var(--text-gray);">(4.5 / 5 - 24 reviews)</span>
                    </div>

                    <div class="price-section">
                        <div style="display: flex; align-items: baseline; gap: 15px;">
                            <h2 style="font-size: 2rem; color: var(--primary-color); margin: 0;">Rs. {{ number_format($product->price, 2) }}</h2>
                            @if($product->old_price && $product->old_price > $product->price)
                                <span style="text-decoration: line-through; color: var(--text-gray); font-size: 1.2rem;">Rs. {{ number_format($product->old_price, 2) }}</span>
                                <span style="background: #e74c3c; color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.9rem;">
                                    -{{ round((($product->old_price - $product->price) / $product->old_price) * 100) }}%
                                </span>
                            @endif
                        </div>
                    </div>

                    <p style="line-height: 1.8; color: var(--text-gray); margin-bottom: 30px;">
                        {{ $product->description }}
                    </p>

                    <div style="margin-bottom: 20px;">
                        <strong>Availability:</strong>
                        @if($product->stock > 0)
                            <span style="color: #28a745;">In Stock ({{ $product->stock }} available)</span>
                        @else
                            <span style="color: #e74c3c;">Out of Stock</span>
                        @endif
                    </div>

                    @if($product->stock > 0)
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="quantity-selector">
                                <label style="font-weight: 500;">Quantity:</label>
                                <button type="button" onclick="decreaseQty()">-</button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" readonly>
                                <button type="button" onclick="increaseQty()">+</button>
                            </div>

                            <div style="display: flex; gap: 15px; margin-top: 30px;">
                                <button type="submit" class="btn-primary" style="flex: 1; padding: 15px;">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                                <button type="button" onclick="toggleWishlist({{ $product->id }})" style="width: 60px; height: 60px; border: 2px solid var(--primary-color); background: white; color: var(--primary-color); border-radius: 10px; cursor: pointer;">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                        </form>
                    @else
                        <button class="btn-primary" disabled style="opacity: 0.5; cursor: not-allowed; width: 100%; padding: 15px;">
                            Out of Stock
                        </button>
                    @endif

                    <div style="margin-top: 30px; padding-top: 30px; border-top: 2px solid var(--border-color);">
                        <div style="display: flex; gap: 30px;">
                            <div>
                                <i class="fas fa-truck" style="color: var(--primary-color); margin-right: 10px;"></i>
                                <strong>Free Delivery</strong>
                                <p style="color: var(--text-gray); font-size: 0.9rem; margin: 5px 0 0 30px;">For orders over Rs. 5,000</p>
                            </div>
                            <div>
                                <i class="fas fa-undo" style="color: var(--primary-color); margin-right: 10px;"></i>
                                <strong>Easy Returns</strong>
                                <p style="color: var(--text-gray); font-size: 0.9rem; margin: 5px 0 0 30px;">30 days return policy</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Tabs -->
            <div class="product-tabs">
                <div class="tab-buttons">
                    <button class="tab-button active" onclick="switchTab('description')">Description</button>
                    <button class="tab-button" onclick="switchTab('reviews')">Reviews </button>
                    <button class="tab-button" onclick="switchTab('shipping')">Shipping Info</button>
                </div>

                <div id="description-tab" class="tab-content" style="display: block;">
                    <h3 style="margin-bottom: 20px;">Product Description</h3>
                    <p style="line-height: 1.8; color: var(--text-gray);">
                        {{ $product->description }}
                    </p>
                </div>

                <div id="reviews-tab" class="tab-content" style="display: none;">
                    <h3 style="margin-bottom: 20px;">Customer Reviews</h3>
                    <p style="color: var(--text-gray);">No reviews yet. Be the first to review this product!</p>
                </div>

                <div id="shipping-tab" class="tab-content" style="display: none;">
                    <h3 style="margin-bottom: 20px;">Shipping Information</h3>
                    <ul style="line-height: 2; color: var(--text-gray);">
                        <li>Free delivery for orders over Rs. 5,000</li>
                        <li>Standard delivery: 3-5 business days</li>
                        <li>Express delivery available</li>
                        <li>Cash on delivery available</li>
                    </ul>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts && count($relatedProducts) > 0)
                <section style="margin-top: 80px;">
                    <h2 style="margin-bottom: 40px; text-align: center;">You May Also Like</h2>
                    <div class="products-grid">
                        @foreach($relatedProducts as $related)
                            <div class="product-card">
                                <div class="product-image">
                                    <a href="{{ route('shop.product.detail', $related->slug) }}">
                                        @if($related->image)
                                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}">
                                        @else
                                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 300'%3E%3Crect fill='%23F5E6F0' width='300' height='300'/%3E%3Ctext x='50%25' y='50%25' font-size='18' text-anchor='middle' fill='%239B5D8F'%3E{{ $related->name }}%3C/text%3E%3C/svg%3E" alt="{{ $related->name }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="product-info">
                                    <div class="product-category">{{ $related->category->name ?? 'Uncategorized' }}</div>
                                    <a href="{{ route('shop.product.detail', $related->slug) }}" style="text-decoration: none; color: inherit;">
                                        <h3 class="product-title">{{ $related->name }}</h3>
                                    </a>
                                    <div class="product-footer">
                                        <div class="product-price">Rs. {{ number_format($related->price, 2) }}</div>
                                        <button class="add-to-cart-btn" onclick="addToCartQuick({{ $related->id }})">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </section>

@endsection

@section('scripts')
<script>
    function increaseQty() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.max);
        const current = parseInt(input.value);
        if (current < max) {
            input.value = current + 1;
        }
    }

    function decreaseQty() {
        const input = document.getElementById('quantity');
        const current = parseInt(input.value);
        if (current > 1) {
            input.value = current - 1;
        }
    }

    function switchTab(tabName) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.style.display = 'none';
        });
        
        // Remove active class from all buttons
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Show selected tab
        document.getElementById(tabName + '-tab').style.display = 'block';
        
        // Add active class to clicked button
        event.target.classList.add('active');
    }

    function toggleWishlist(productId) {
        alert('Wishlist feature coming soon!');
    }

    function addToCartQuick(productId) {
        @guest
            openModal('loginModal');
            return;
        @endguest

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
</script>
@endsection
