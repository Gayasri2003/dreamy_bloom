<div>
    <!-- Filter Section -->
    <section class="filter-section">
        <div class="filter-container">

            <!-- Category Filter (instant apply) -->
            <div class="filter-tags">
                <button type="button"
                        wire:click="setCategory(null)"
                        class="filter-tag {{ $categoryId === null ? 'active' : '' }}">
                    All Products
                </button>

                @foreach($categories as $cat)
                    <button type="button"
                            wire:click="setCategory({{ $cat->id }})"
                            class="filter-tag {{ $categoryId === $cat->id ? 'active' : '' }}">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>

            <!-- Search + Sort (manual apply) -->
            <div style="display:flex; gap: 12px; align-items:center; flex-wrap:wrap;">

                <!-- Search (press Enter or click Apply) -->
                <input type="text"
                       wire:model="searchInput"
                       wire:keydown.enter="applyFilters"
                       placeholder="Search products..."
                       class="sort-dropdown"
                       style="max-width: 240px; padding-right: 20px; background-image: none;" />

                <!-- Sort (applies only when clicking Apply) -->
                <select class="sort-dropdown" wire:model="sortInput">
                    <option value="latest">Latest</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                </select>

                <!-- Apply Button -->
                <button type="button"
                        wire:click="applyFilters"
                        class="filter-tag active"
                        style="border-radius: 10px;">
                    Apply
                </button>

                <!-- Optional Clear Button -->
                <button type="button"
                        wire:click="$set('searchInput',''); $set('sortInput','latest'); applyFilters();"
                        class="filter-tag"
                        style="border-radius: 10px;">
                    Clear
                </button>

            </div>

        </div>
    </section>

    <!-- Loading indicator (only when Livewire request happens) -->
    <div wire:loading wire:target="applyFilters,setCategory"
         style="text-align:center; padding: 18px; font-weight: 600; color: var(--primary-color);">
        Loading...
    </div>

    <!-- Products Grid -->
    <section class="products-section" wire:loading.remove wire:target="applyFilters,setCategory">
        <div class="container">
            <div class="products-grid">

                @forelse($products as $product)
                    <div class="product-card"
                         onclick="window.location.href='{{ route('shop.product.detail', $product->slug) }}'"
                         style="cursor: pointer;">

                        <div class="product-image">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 300'%3E%3Crect fill='%23F5E6F0' width='300' height='300'/%3E%3Ctext x='50%25' y='50%25' font-size='18' text-anchor='middle' fill='%239B5D8F'%3E{{ $product->name }}%3C/text%3E%3C/svg%3E"
                                     alt="{{ $product->name }}">
                            @endif
                        </div>

                        <div class="product-info">
                            <div class="product-category">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </div>

                            <h3 class="product-title">{{ $product->name }}</h3>

                            <p class="product-description">
                                {{ \Illuminate\Support\Str::limit($product->description, 60) }}
                            </p>

                            <div class="product-price"
                                 style="margin: 15px 0; font-size: 1.3rem; color: var(--primary-color); font-weight: 700;">
                                Rs. {{ number_format($product->price, 2) }}
                            </div>
                        </div>

                        <div class="product-actions-bottom"
                             style="padding: 0 20px 20px; display: flex; gap: 10px;"
                             onclick="event.stopPropagation();">

                            @auth
                                <form action="{{ route('cart.add') }}" method="POST" style="flex: 1;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">

                                    <button type="submit"
                                            class="btn-cart"
                                            style="width: 100%; padding: 12px; border: none; background: var(--bg-pink); color: var(--primary-color); border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s;">
                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}"
                                   class="btn-cart"
                                   style="flex: 1; padding: 12px; border: none; background: var(--bg-pink); color: var(--primary-color); border-radius: 8px; text-decoration: none; font-weight: 600; text-align: center; display: block;">
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
</div>
