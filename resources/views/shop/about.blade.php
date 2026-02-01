@extends('layouts.modern')

@section('title', 'About Us - DreamyBloom')

@section('styles')
<style>
    .about-hero {
        background: linear-gradient(135deg, rgba(155, 93, 143, 0.85), rgba(220, 145, 198, 0.85)), url('{{ asset('img/home_image.jpeg') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        padding: 120px 0;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .about-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
        border-radius: 50%;
    }
    .about-hero h1 {
        font-size: 3.5rem;
        color: white;
        margin-bottom: 15px;
        position: relative;
        z-index: 2;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    .about-hero p {
        font-size: 1.2rem;
        color: white;
        position: relative;
        z-index: 2;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    }
    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }
    .about-image-wrapper {
        position: relative;
    }
    .about-image-wrapper img {
        width: 100%;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }
    .about-badge {
        position: absolute;
        bottom: -20px;
        right: -20px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(155, 93, 143, 0.4);
        text-align: center;
    }
    .about-badge h3 {
        font-size: 2.5rem;
        margin-bottom: 5px;
    }
    .about-badge p {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    .stats-section {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        padding: 60px 0;
        color: white;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 40px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    .stat-item {
        text-align: center;
    }
    .stat-number {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
    .stat-label {
        font-size: 1.1rem;
        opacity: 0.9;
    }
    @media (max-width: 768px) {
        .about-grid {
            grid-template-columns: 1fr;
        }
        .about-hero h1 {
            font-size: 2.5rem;
        }
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .about-badge {
            position: static;
            margin-top: 20px;
        }
    }
</style>
@endsection

@section('content')

    <!-- Page Hero -->
    <section class="about-hero">
        <h1> About DreamyBloom</h1>
        <p>Your trusted partner in beauty and self-care since 2020</p>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Cpath fill='%239B5D8F' d='M32 8L8 20v24c0 8 24 20 24 20s24-12 24-20V20L32 8z'/%3E%3C/svg%3E" alt="Safe Shopping">
                </div>
                <h3>Safe Shopping</h3>
                <p>Your order is packed with care and delivered safely to your doorstep.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Ccircle fill='%239B5D8F' cx='32' cy='20' r='12'/%3E%3Cpath fill='%239B5D8F' d='M32 36c-12 0-20 6-20 12v8h40v-8c0-6-8-12-20-12z'/%3E%3C/svg%3E" alt="Customer Support">
                </div>
                <h3>Customer Support</h3>
                <p>Customer support team is here to help you with any questions or issues.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect fill='%239B5D8F' x='12' y='16' width='40' height='32' rx='4'/%3E%3Cpath fill='white' d='M20 28h24M20 36h16'/%3E%3C/svg%3E" alt="Secure Payments">
                </div>
                <h3>Secure Payments</h3>
                <p>We use trusted payment methods to keep your transactions safe and protected.</p>
            </div>
        </div>
    </section>

    <!-- About Content -->
    <section style="padding: 80px 0; background: white;">
        <div class="container">
            <div class="about-grid">
                <div class="about-image-wrapper">
                    <img src="{{ asset('img/home_image.jpeg') }}" alt="About DreamyBloom">
                    <div class="about-badge">
                        <h3>5+</h3>
                        <p>Years of Excellence</p>
                    </div>
                </div>
                <div>
                    <h2 style="margin-bottom: 25px; font-size: 2.5rem; color: var(--primary-color);">Our Story</h2>
                    <p style="margin-bottom: 20px; line-height: 1.8; color: var(--text-dark); font-size: 1.05rem;">Founded in 2020, DreamyBloom is an online cosmetic store built on the belief that beauty should be accessible, trustworthy, and enjoyable for everyone. From everyday essentials to premium makeup, we handpick products that combine quality, safety, and effectiveness.</p>
                    <p style="margin-bottom: 20px; line-height: 1.8; color: var(--text-dark); font-size: 1.05rem;">Our mission is to inspire confidence and self-care by offering a wide variety of brands and solutions for every skin type and need. With secure shopping, friendly customer support, and fast delivery, DreamyBloom has become a trusted choice for beauty lovers across Sri Lanka.</p>
                    <div style="display: flex; gap: 15px; margin-top: 30px;">
                        <div style="flex: 1; padding: 20px; background: var(--bg-light-pink); border-radius: 15px; text-align: center;">
                            <i class="fas fa-star" style="font-size: 2rem; color: var(--primary-color); margin-bottom: 10px;"></i>
                            <h4 style="color: var(--primary-color);">Premium Quality</h4>
                            <p style="color: var(--text-gray); font-size: 0.9rem; margin-top: 5px;">Authentic products only</p>
                        </div>
                        <div style="flex: 1; padding: 20px; background: var(--bg-light-pink); border-radius: 15px; text-align: center;">
                            <i class="fas fa-shipping-fast" style="font-size: 2rem; color: var(--primary-color); margin-bottom: 10px;"></i>
                            <h4 style="color: var(--primary-color);">Fast Delivery</h4>
                            <p style="color: var(--text-gray); font-size: 0.9rem; margin-top: 5px;">Islandwide shipping</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number"><i class="fas fa-users"></i> 5K+</div>
                <div class="stat-label">Happy Customers</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><i class="fas fa-box"></i> 10K+</div>
                <div class="stat-label">Orders Delivered</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><i class="fas fa-shopping-bag"></i> 500+</div>
                <div class="stat-label">Products Available</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><i class="fas fa-award"></i> 100%</div>
                <div class="stat-label">Authentic Products</div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-title">
                <h2>Customer Reviews</h2>
            </div>
            <div class="testimonials-grid">
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
                    <p class="testimonial-text">I got the package. Well packed and original stuff. Thank you very much dreamy bloom... Totally recommend the store!</p>
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
                    <p class="testimonial-text">Great products, great deals and best ever customer care and delivery service!</p>
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
                    <p class="testimonial-text">DreamyBloom always delivers high-quality products on time, and their customer support is super friendly!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section style="padding: 60px 0; background: white; text-align: center;">
        <div class="container">
            <h2 style="margin-bottom: 30px;">Why Choose Us?</h2>
            <p style="max-width: 800px; margin: 0 auto; line-height: 1.8; font-size: 1.1rem;">At DreamyBloom, we bring you a wide range of skincare, makeup, and beauty essentials designed to suit every style and need. Our products come at competitive prices, with exciting seasonal promotions to help you save more. With secure payment options and a hassle-free checkout process, we make your shopping experience smooth and reliable. Plus, we ensure fast delivery across Sri Lanka so your favorites reach you on time, while our friendly customer support team is always ready to assist whenever you need help.</p>
        </div>
    </section>

@endsection
