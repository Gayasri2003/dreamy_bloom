<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DreamyBloom - Where Your Beauty Blossoms')</title>
    <meta name="keywords" content="@yield('meta_keywords', 'beauty products, skincare, cosmetics, makeup')">
    <meta name="description" content="@yield('meta_description', 'DreamyBloom - Premium cosmetics and skincare products')">
    
    <link rel="stylesheet" href="{{ asset('css/modern-style.css') }}?v={{ md5_file(public_path('css/modern-style.css')) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @livewireStyles
    @yield('styles')
</head>
<body>
    <!-- NO CACHE -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div>
                <a href="tel:+94112345678"><i class="fas fa-phone"></i>+9411 2345 678</a>
            </div>
            <div style="text-align: center; flex: 1;">
                <span>Where Your Beauty Blossoms</span>
            </div>
            <div>
                <a href="mailto:support@dreamybloom.lk"><i class="fas fa-envelope"></i>support@dreamybloom.lk</a>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header>
        <div class="container">
            <div class="logo">
                <img src="{{ asset('img/DreamyBloom_Logo.png') }}" alt="DreamyBloom Logo" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Ccircle cx=%2250%22 cy=%2250%22 r=%2240%22 fill=%22%239B5D8F%22/%3E%3Ctext x=%2250%22 y=%2260%22 font-size=%2240%22 text-anchor=%22middle%22 fill=%22white%22%3EDB%3C/text%3E%3C/svg%3E'">
                <div class="logo-text">
                    <h1>DreamyBloom</h1>
                    <p>Beauty & Skincare</p>
                </div>
            </div>

            <div class="search-container">
                <div class="search-box">
                    <form action="{{ route('shop.products') }}" method="GET">
                        <input type="text" name="search" placeholder="Search Products..." id="searchInput" value="{{ request('search') }}">
                        <i class="fas fa-search"></i>
                    </form>
                </div>
            </div>

            <div class="header-icons">
                @auth
                    <div class="user-dropdown" style="position: relative;">
                        <a href="#" onclick="toggleUserMenu(); return false;" style="display: flex; align-items: center; gap: 8px; padding: 8px 15px; background: rgba(255,255,255,0.1); border-radius: 25px;">
                            <i class="fas fa-user-circle" style="font-size: 1.2rem;"></i>
                            <span style="font-size: 0.9rem;">{{ Str::limit(auth()->user()->name, 15) }}</span>
                            <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
                        </a>
                        <div id="userMenu" style="display: none; position: absolute; top: 100%; right: 0; margin-top: 10px; background: white; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.15); min-width: 200px; z-index: 1000;">
                            <a href="{{ route('cart.index') }}" style="display: flex; align-items: center; gap: 10px; padding: 12px 20px; color: var(--text-dark); text-decoration: none; border-bottom: 1px solid var(--border-color);">
                                <i class="fas fa-shopping-cart" style="color: var(--primary-color);"></i>
                                <span>My Cart</span>
                            </a>
                            <a href="{{ route('orders.index') }}" style="display: flex; align-items: center; gap: 10px; padding: 12px 20px; color: var(--text-dark); text-decoration: none; border-bottom: 1px solid var(--border-color);">
                                <i class="fas fa-box" style="color: var(--primary-color);"></i>
                                <span>My Orders</span>
                            </a>
                            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" style="width: 100%; display: flex; align-items: center; gap: 10px; padding: 12px 20px; background: none; border: none; color: #e74c3c; cursor: pointer; border-radius: 0 0 10px 10px; text-align: left; font-family: inherit; font-size: 1rem;">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <a href="{{ route('cart.index') }}" style="position: relative;">
                        <i class="fas fa-shopping-cart"></i>
                        @php
                            $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                        @endphp
                        <span class="cart-count" style="position: absolute; top: -8px; right: -8px; background: white; color: var(--primary-color); border-radius: 50%; width: 20px; height: 20px; font-size: 0.75rem; display: flex; align-items: center; justify-content: center; font-weight: bold;">{{ $cartCount ?? 0 }}</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" style="display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-user"></i>
                    </a>
                    <a href="{{ route('register') }}" class="register-btn" style="background: rgba(255,255,255,0.2); color: var(--white); padding: 8px 20px; border-radius: 20px; font-size: 0.9rem; font-weight: 600; text-decoration: none; margin-right: 10px; border: 2px solid var(--white);">Register</a>
                    <a href="{{ route('login') }}" class="login-btn" style="background: var(--white); color: var(--primary-color); padding: 8px 20px; border-radius: 20px; font-size: 0.9rem; font-weight: 600; text-decoration: none;">Login</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav>
        <div class="container">
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="Toggle menu">
                <i class="fas fa-bars"></i>
            </button>
            <ul id="mobileMenu">
                <li><a href="{{ route('shop.home') }}" class="{{ request()->routeIs('shop.home') ? 'nav-active' : '' }}">Home</a></li>
                <li><a href="{{ route('shop.products') }}" class="{{ request()->routeIs('shop.products') ? 'nav-active' : '' }}">Products</a></li>
                <li><a href="{{ route('shop.about') }}" class="{{ request()->routeIs('shop.about') ? 'nav-active' : '' }}">About</a></li>
                <li><a href="{{ route('shop.contact') }}" class="{{ request()->routeIs('shop.contact') ? 'nav-active' : '' }}">Contact</a></li>
                @guest
                    <li class="mobile-only"><a href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Register</a></li>
                    <li class="mobile-only"><a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                @else
                    <li class="mobile-only"><a href="{{ route('cart.index') }}"><i class="fas fa-shopping-cart"></i> My Cart</a></li>
                    <li class="mobile-only"><a href="{{ route('orders.index') }}"><i class="fas fa-box"></i> My Orders</a></li>
                    <li class="mobile-only">
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" style="width: 100%; background: none; border: none; color: white; padding: 15px 20px; text-align: left; cursor: pointer; font-size: 1.1rem;">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3" style="z-index: 9999;" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">✕</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3" style="z-index: 9999;" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">✕</button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show position-fixed top-0 end-0 m-3" style="z-index: 9999;" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">✕</button>
        </div>
    @endif

    @yield('content')

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <div class="logo" style="margin-bottom: 20px;">
                    <img src="{{ asset('img/DreamyBloom_Logo.png') }}" alt="DreamyBloom Logo" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Ccircle cx=%2250%22 cy=%2250%22 r=%2240%22 fill=%22white%22/%3E%3Ctext x=%2250%22 y=%2260%22 font-size=%2240%22 text-anchor=%22middle%22 fill=%22%239B5D8F%22%3EDB%3C/text%3E%3C/svg%3E'">
                    <div class="logo-text">
                        <h1 style="color: white;">DreamyBloom</h1>
                    </div>
                </div>
                <p>DreamyBloom is your trusted destination for premium cosmetics, skincare, and beauty essentials. We are committed to bringing you quality products that inspire confidence and self-care every day.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Menu</h3>
                <ul>
                    <li><a href="{{ route('shop.home') }}">Home</a></li>
                    <li><a href="{{ route('shop.products') }}">Product</a></li>
                    <li><a href="{{ route('shop.about') }}">About</a></li>
                    <li><a href="{{ route('shop.contact') }}">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Help</h3>
                <ul>
                    <li><a href="#">Shipping Information</a></li>
                    <li><a href="#">Returns & Exchange</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Have a question?</h3>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i>No.63/5 Colombo Road, Kandy</li>
                    <li><i class="fas fa-phone"></i>+9411 2345 678</li>
                    <li><i class="fas fa-envelope"></i>support@dreamybloom.lk</li>
                    <li><i class="fas fa-globe"></i>WWW.DreamyBloom.lk</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Copyright ©2025 All rights reserved</p>
        </div>
    </footer>



    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('mobile-menu-active');
        }

        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        }

        // Close menus when clicking outside
        document.addEventListener('click', function(event) {
            const userDropdown = document.querySelector('.user-dropdown');
            const userMenu = document.getElementById('userMenu');
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileToggle = document.querySelector('.mobile-menu-toggle');
            
            // Close user menu
            if (userDropdown && userMenu && !userDropdown.contains(event.target)) {
                userMenu.style.display = 'none';
            }
            
            // Close mobile menu when clicking outside
            if (mobileMenu && mobileToggle && 
                !mobileMenu.contains(event.target) && 
                !mobileToggle.contains(event.target)) {
                mobileMenu.classList.remove('mobile-menu-active');
            }
        });

        // Close mobile menu when clicking on a link
        document.querySelectorAll('#mobileMenu a').forEach(link => {
            link.addEventListener('click', function() {
                const menu = document.getElementById('mobileMenu');
                menu.classList.remove('mobile-menu-active');
            });
        });

        function toggleWishlist() {
            alert('Wishlist feature coming soon!');
        }
    </script>
    @livewireScripts
    @yield('scripts')
</body>
</html>
