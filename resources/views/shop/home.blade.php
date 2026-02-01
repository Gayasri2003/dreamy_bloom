@extends('layouts.modern')

@section('title', 'DreamyBloom - Where Your Beauty Blossoms')

@section('styles')
<style>
    /* Force browser to reload - Cache buster: {{ now() }} */
    .hero-carousel {
        position: relative;
        overflow: hidden;
        height: 650px;
        background: #000;
    }
    .carousel-slide {
        display: none;
        animation: fadeIn 0.8s ease-in-out;
        position: absolute;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
    }
    .carousel-slide::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(155, 93, 143, 0.7) 0%, rgba(220, 145, 198, 0.5) 100%);
        z-index: 1;
    }
    .carousel-slide.active {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        height: 100%;
        padding: 0 100px;
        position: relative;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(1.05); }
        to { opacity: 1; transform: scale(1); }
    }
    .carousel-content {
        position: relative;
        z-index: 2;
    }
    .carousel-content h1 {
        font-size: 4rem;
        margin-bottom: 25px;
        color: white;
        font-weight: 800;
        line-height: 1.2;
        text-shadow: 2px 4px 8px rgba(0,0,0,0.3);
        animation: slideInLeft 0.8s ease-out;
    }
    @keyframes slideInLeft {
        from { transform: translateX(-80px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .carousel-content p {
        font-size: 1.25rem;
        margin-bottom: 35px;
        color: rgba(255, 255, 255, 0.95);
        line-height: 1.8;
        text-shadow: 1px 2px 4px rgba(0,0,0,0.2);
        animation: slideInLeft 0.8s 0.2s both ease-out;
    }
    .carousel-image {
        position: relative;
        z-index: 2;
        animation: slideInRight 0.8s 0.3s both ease-out;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    @keyframes slideInRight {
        from { transform: translateX(80px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .carousel-image img {
        width: 550px;
        height: 450px;
        object-fit: cover;
        border-radius: 25px;
        box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
        border: 5px solid rgba(255, 255, 255, 0.2);
        transition: all 0.4s;
    }
    .carousel-image:hover img {
        transform: scale(1.05) rotate(-2deg);
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
    }
    .carousel-dots {
        position: absolute;
        bottom: 40px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 12px;
        z-index: 10;
    }
    .dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: rgba(255,255,255,0.4);
        cursor: pointer;
        transition: all 0.4s;
        border: 2px solid rgba(255,255,255,0.6);
    }
    .dot:hover {
        background: rgba(255,255,255,0.7);
        transform: scale(1.2);
    }
    .dot.active {
        background: white;
        width: 50px;
        border-radius: 7px;
        box-shadow: 0 4px 15px rgba(255,255,255,0.4);
    }
    .carousel-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.4s;
        z-index: 10;
        color: white;
        font-size: 1.3rem;
    }
    .carousel-nav:hover {
        background: white;
        color: var(--primary-color);
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 8px 25px rgba(255,255,255,0.3);
    }
    .carousel-nav.prev { left: 40px; }
    .carousel-nav.next { right: 40px; }
    
    .carousel-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: rgba(255,255,255,0.2);
        z-index: 10;
    }
    .carousel-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, white, var(--primary-color));
        width: 0;
        animation: progressBar 5s linear;
    }
    @keyframes progressBar {
        from { width: 0; }
        to { width: 100%; }
    }
    
    .btn-primary {
        background: white;
        color: var(--primary-color);
        padding: 16px 45px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.05rem;
        text-decoration: none;
        transition: all 0.4s;
        box-shadow: 0 8px 25px rgba(255,255,255,0.3);
        animation: slideInLeft 0.8s 0.4s both ease-out;
    }
    .btn-primary:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(255,255,255,0.4);
    }
    .btn-primary i {
        margin-left: 8px;
        transition: transform 0.3s;
    }
    .btn-primary:hover i {
        transform: translateX(5px);
    }
    .feature-card {
        position: relative;
        overflow: hidden;
    }
    .feature-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(155, 93, 143, 0.1) 0%, transparent 70%);
        opacity: 0;
        transition: all 0.6s;
    }
    .feature-card:hover::before {
        opacity: 1;
        top: 0;
        left: 0;
    }
    .feature-card:hover {
        transform: translateY(-10px);
    }
    .feature-icon-box {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s;
    }
    .feature-card:hover .feature-icon-box {
        transform: rotate(360deg) scale(1.1);
    }
    .product-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 700;
        z-index: 5;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    @media (max-width: 768px) {
        .carousel-slide.active {
            grid-template-columns: 1fr;
            padding: 40px 20px;
            gap: 30px;
        }
        .carousel-content h1 { 
            font-size: 2rem; 
            margin-bottom: 15px;
        }
        .carousel-content p {
            font-size: 1rem;
            margin-bottom: 25px;
        }
        .carousel-image img {
            width: 100%;
            max-width: 400px;
            height: 300px;
        }
        .hero-carousel { 
            height: auto; 
            min-height: 500px; 
        }
        .carousel-nav { 
            width: 45px;
            height: 45px;
            font-size: 1rem;
        }
        .carousel-nav.prev { left: 10px; }
        .carousel-nav.next { right: 10px; }
        .carousel-dots {
            bottom: 20px;
            gap: 8px;
        }
        .dot {
            width: 10px;
            height: 10px;
        }
        .dot.active {
            width: 35px;
        }
        .btn-primary {
            padding: 12px 30px;
            font-size: 0.95rem;
        }
    }
    
    @media (max-width: 480px) {
        .carousel-content h1 { 
            font-size: 1.5rem; 
        }
        .carousel-content p {
            font-size: 0.9rem;
        }
        .carousel-image img {
            height: 250px;
        }
        .hero-carousel { 
            min-height: 450px; 
        }
        .btn-primary {
            padding: 10px 25px;
            font-size: 0.9rem;
        }
        .carousel-nav {
            width: 40px;
            height: 40px;
        }
    }
</style>
@endsection

@section('content')

    <!-- Hero Carousel -->
    <section class="hero-carousel">
        <div class="carousel-slide active" style="background-image: url('{{ asset('img/home_image.jpeg') }}');">
            <div class="carousel-content">
                <h1>Enhance Your Natural Beauty</h1>
                <p>Discover premium cosmetics, skincare, and beauty essentials that inspire confidence and self-care every day.</p>
                <a href="{{ route('shop.products') }}" class="btn-primary">Shop Now <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="carousel-image">
                <img src="{{ asset('img/c1.jpg') }}" alt="Beauty Products">
            </div>
        </div>
        <div class="carousel-slide" style="background-image: url('{{ asset('img/c2.jpeg') }}');">
            <div class="carousel-content">
                <h1>Makeup That Empowers</h1>
                <p>From everyday looks to glamorous transformations, find the perfect products to express your unique style.</p>
                <a href="{{ route('shop.products', ['category' => 'makeup']) }}" class="btn-primary">Explore Makeup <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="carousel-image">
                <img src="{{ asset('img/c3.webp') }}" alt="Makeup Collection">
            </div>
        </div>
        <div class="carousel-slide" style="background-image: url('{{ asset('img/c4.jpg') }}');">
            <div class="carousel-content">
                <h1>Skincare Essentials</h1>
                <p>Nurture your skin with our carefully curated collection of cleansers, serums, moisturizers, and treatments.</p>
                <a href="{{ route('shop.products', ['category' => 'skincare']) }}" class="btn-primary">Shop Skincare <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="carousel-image">
                <img src="{{ asset('img/c5.png') }}" alt="Skincare Products">
            </div>
        </div>
        
        <div class="carousel-nav prev" onclick="changeSlide(-1)">
            <i class="fas fa-chevron-left"></i>
        </div>
        <div class="carousel-nav next" onclick="changeSlide(1)">
            <i class="fas fa-chevron-right"></i>
        </div>
        
        <div class="carousel-dots">
            <span class="dot active" onclick="currentSlide(0)"></span>
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
        </div>
        
        <div class="carousel-progress">
            <div class="carousel-progress-bar"></div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" style="background: white; padding: 60px 0;">
        <div class="features-grid">
            <div class="feature-card" style="background: linear-gradient(135deg, #fff5f7 0%, #ffe5ec 100%); padding: 40px 30px; border-radius: 20px; text-align: center; transition: all 0.4s; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <div class="feature-icon" style="margin-bottom: 20px;">
                    <div class="feature-icon-box" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); box-shadow: 0 10px 30px rgba(155, 93, 143, 0.3); transform: rotate(5deg);">
                        <i class="fas fa-shield-alt" style="font-size: 2.5rem; color: white; transform: rotate(-5deg);"></i>
                    </div>
                </div>
                <h3 style="margin-bottom: 15px; color: var(--primary-color); font-size: 1.3rem;">Safe Shopping</h3>
                <p style="color: var(--text-gray); line-height: 1.6;">Your order is packed with care and delivered safely to your doorstep with secure packaging.</p>
            </div>
            <div class="feature-card" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); padding: 40px 30px; border-radius: 20px; text-align: center; transition: all 0.4s; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <div class="feature-icon" style="margin-bottom: 20px;">
                    <div class="feature-icon-box" style="background: linear-gradient(135deg, #3b82f6, #2563eb); box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3); transform: rotate(-5deg);">
                        <i class="fas fa-headset" style="font-size: 2.5rem; color: white; transform: rotate(5deg);"></i>
                    </div>
                </div>
                <h3 style="margin-bottom: 15px; color: #2563eb; font-size: 1.3rem;">Customer Support</h3>
                <p style="color: var(--text-gray); line-height: 1.6;">Our friendly support team is here to help you with any questions or concerns you may have.</p>
            </div>
            <div class="feature-card" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); padding: 40px 30px; border-radius: 20px; text-align: center; transition: all 0.4s; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <div class="feature-icon" style="margin-bottom: 20px;">
                    <div class="feature-icon-box" style="background: linear-gradient(135deg, #22c55e, #16a34a); box-shadow: 0 10px 30px rgba(34, 197, 94, 0.3); transform: rotate(5deg);">
                        <i class="fas fa-lock" style="font-size: 2.5rem; color: white; transform: rotate(-5deg);"></i>
                    </div>
                </div>
                <h3 style="margin-bottom: 15px; color: #16a34a; font-size: 1.3rem;">Secure Payments</h3>
                <p style="color: var(--text-gray); line-height: 1.6;">We use trusted payment methods to keep your transactions safe and completely protected.</p>
            </div>
        </div>
    </section>

    <!-- New Arrivals -->
    <section class="products-section">
        <div class="container">
            <div class="section-title">
                <h2>New Arrivals</h2>
                <p>Check out our latest beauty and skincare products</p>
            </div>
            <div class="products-grid">
                @forelse($recentProducts as $product)
                    <div class="product-card" onclick="window.location.href='{{ route('shop.product.detail', $product->slug) }}'" style="cursor: pointer;">
                        <div class="product-image">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 300'%3E%3Crect fill='%23F5E6F0' width='300' height='300'/%3E%3Ctext x='50%25' y='50%25' font-size='18' text-anchor='middle' fill='%239B5D8F'%3ENo Image%3C/text%3E%3C/svg%3E" alt="{{ $product->name }}">
                            @endif
                        </div>
                        <div class="product-info">
                            <div class="product-category">{{ $product->category->name ?? 'Uncategorized' }}</div>
                            <h3 class="product-title">{{ $product->name }}</h3>
                            <p class="product-description">{{ Str::limit($product->description, 60) }}</p>
                            <div class="product-price">Rs. {{ number_format($product->price, 2) }}</div>
                        </div>
                        <div class="product-actions-bottom" onclick="event.stopPropagation();">
                            @auth
                                <form action="{{ route('cart.add') }}" method="POST" style="flex: 1;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-cart">
                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn-cart">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; grid-column: 1 / -1; padding: 40px;">
                        <p>No products available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section">
        <div class="container">
            <div class="section-title">
                <h2>Shop by Category</h2>
                <p>Find the perfect products for your beauty needs</p>
            </div>
            <div class="categories-grid" id="categoriesGrid">
                @if($categories && count($categories) > 0)
                    @foreach($categories as $category)
                        <a href="{{ route('shop.products', ['category' => $category->slug]) }}" class="category-card">
                            <div class="category-image">
                                @if($category->image)<img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}">
@endif
                            </div>
                            <h3>{{ $category->name }}</h3>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- Promotional Banners -->
    <section class="features-section" style="background: var(--bg-light-pink);">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                <div style="background: white; padding: 40px; border-radius: 15px; text-align: center;">
                    <h2 style="color: var(--text-dark); margin-bottom: 15px;">The latest beauty and skin care products at your fingertips</h2>
                    <p style="color: var(--text-gray);">Explore our curated collection of premium beauty essentials.</p>
                </div>
                <div style="background: white; padding: 40px; border-radius: 15px; text-align: center;">
                    <h2 style="color: var(--text-dark); margin-bottom: 15px;">Revamp your beauty routine!</h2>
                    <p style="color: var(--text-gray);">Discover products that enhance your natural glow.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Customer Reviews -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-title">
                <h2>Customer Reviews</h2>
                <p>What our customers say about us</p>
            </div>
            <div class="testimonials-grid">
                @if($testimonials && count($testimonials) > 0)
                    @foreach($testimonials->take(3) as $testimonial)
                        <div class="testimonial-card">
                            <div class="testimonial-header">
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle fill='%23C291B4' cx='50' cy='50' r='50'/%3E%3Ccircle fill='%23fff' cx='50' cy='40' r='15'/%3E%3Cpath fill='%23fff' d='M50 60c-12 0-20 6-20 12v8h40v-8c0-6-8-12-20-12z'/%3E%3C/svg%3E" alt="Customer" class="testimonial-avatar">
                                <div class="testimonial-info">
                                    <h4>{{ $testimonial->name }}</h4>
                                    <div class="testimonial-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $testimonial->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="testimonial-text">{{ $testimonial->message }}</p>
                        </div>
                    @endforeach
                @else
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle fill='%23C291B4' cx='50' cy='50' r='50'/%3E%3Ccircle fill='%23fff' cx='50' cy='40' r='15'/%3E%3Cpath fill='%23fff' d='M50 60c-12 0-20 6-20 12v8h40v-8c0-6-8-12-20-12z'/%3E%3C/svg%3E" alt="Customer" class="testimonial-avatar">
                            <div class="testimonial-info">
                                <h4>Sarah Johnson</h4>
                                <div class="testimonial-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p class="testimonial-text">I got the package. Well packed and original stuff. Thank you very much dreamy bloom... Totally recommend the store for the people who looking for genuine stuff... Thanks again... Hope to deal with you again.</p>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle fill='%23C291B4' cx='50' cy='50' r='50'/%3E%3Ccircle fill='%23fff' cx='50' cy='40' r='15'/%3E%3Cpath fill='%23fff' d='M50 60c-12 0-20 6-20 12v8h40v-8c0-6-8-12-20-12z'/%3E%3C/svg%3E" alt="Customer" class="testimonial-avatar">
                            <div class="testimonial-info">
                                <h4>Emma Wilson</h4>
                                <div class="testimonial-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p class="testimonial-text">Great products, great deals and best ever customer care and delivery service that I have ever come across. Keep up the good work! Try widening your collection into perfumes and other related cosmetics! Cheers!</p>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle fill='%23C291B4' cx='50' cy='50' r='50'/%3E%3Ccircle fill='%23fff' cx='50' cy='40' r='15'/%3E%3Cpath fill='%23fff' d='M50 60c-12 0-20 6-20 12v8h40v-8c0-6-8-12-20-12z'/%3E%3C/svg%3E" alt="Customer" class="testimonial-avatar">
                            <div class="testimonial-info">
                                <h4>Olivia Brown</h4>
                                <div class="testimonial-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p class="testimonial-text">DreamyBloom always delivers high-quality products on time, and their customer support is super friendly and helpful! Achieving a glowing complexion is easier with the right skincare. Vitamin C is one of the best ingredients for brightening and even-toning your skin.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
    // Hero Carousel
    let currentSlide = 0;
    const slides = document.querySelectorAll('.carousel-slide');
    const dots = document.querySelectorAll('.dot');
    let autoSlideInterval;
    
    function restartProgressBar() {
        const progressBar = document.querySelector('.carousel-progress-bar');
        if (progressBar) {
            progressBar.style.animation = 'none';
            setTimeout(() => {
                progressBar.style.animation = 'progressBar 5s linear';
            }, 10);
        }
    }
    
    function showSlide(n) {
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        if (n >= slides.length) currentSlide = 0;
        if (n < 0) currentSlide = slides.length - 1;
        
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
        restartProgressBar();
    }
    
    function changeSlide(n) {
        currentSlide += n;
        showSlide(currentSlide);
        resetAutoSlide();
    }
    
    function currentSlideIndex(n) {
        currentSlide = n;
        showSlide(currentSlide);
        resetAutoSlide();
    }
    
    function resetAutoSlide() {
        clearInterval(autoSlideInterval);
        autoSlideInterval = setInterval(() => {
            currentSlide++;
            showSlide(currentSlide);
        }, 5000);
    }
    
    // Auto advance carousel
    autoSlideInterval = setInterval(() => {
        currentSlide++;
        showSlide(currentSlide);
    }, 5000);

    
    // Wishlist toggle
    function toggleWishlist(productId) {
        alert('Wishlist feature coming soon!');
    }
</script>
@endsection
