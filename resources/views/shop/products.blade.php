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

<livewire:product-search />

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
