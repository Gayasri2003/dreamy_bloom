// DreamyBloom E-Commerce App JavaScript

// API Base URL
const API_BASE = '/api';

// Authentication State
let isAuthenticated = false;
let currentUser = null;
let authToken = localStorage.getItem('auth_token');

// Cart State
let cart = [];
let wishlist = [];

// Initialize App
document.addEventListener('DOMContentLoaded', function() {
    initAuth();
    initModals();
    initCart();
    initWishlist();
    initScrollEffects();
    initAnimations();
    loadProducts();
    loadCategories();
});

// Authentication Functions
function initAuth() {
    if (authToken) {
        fetchUserData();
    }
}

async function fetchUserData() {
    try {
        const response = await fetch(`${API_BASE}/user`, {
            headers: {
                'Authorization': `Bearer ${authToken}`,
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            currentUser = await response.json();
            isAuthenticated = true;
            updateAuthUI();
        } else {
            logout();
        }
    } catch (error) {
        console.error('Error fetching user data:', error);
    }
}

function updateAuthUI() {
    const loginBtn = document.querySelector('.login-btn');
    if (loginBtn && isAuthenticated) {
        loginBtn.textContent = currentUser.name || 'Profile';
        loginBtn.href = '/profile';
    }
}

async function login(email, password) {
    try {
        const response = await fetch(`${API_BASE}/login`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });
        
        const data = await response.json();
        
        if (response.ok) {
            authToken = data.token;
            localStorage.setItem('auth_token', authToken);
            currentUser = data.user;
            isAuthenticated = true;
            updateAuthUI();
            closeModal('loginModal');
            showNotification('Login successful!', 'success');
            return true;
        } else {
            showNotification(data.message || 'Login failed', 'error');
            return false;
        }
    } catch (error) {
        console.error('Login error:', error);
        showNotification('An error occurred during login', 'error');
        return false;
    }
}

async function register(name, email, password) {
    try {
        const response = await fetch(`${API_BASE}/register`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name, email, password, password_confirmation: password })
        });
        
        const data = await response.json();
        
        if (response.ok) {
            authToken = data.token;
            localStorage.setItem('auth_token', authToken);
            currentUser = data.user;
            isAuthenticated = true;
            updateAuthUI();
            closeModal('registerModal');
            showNotification('Registration successful!', 'success');
            return true;
        } else {
            showNotification(data.message || 'Registration failed', 'error');
            return false;
        }
    } catch (error) {
        console.error('Registration error:', error);
        showNotification('An error occurred during registration', 'error');
        return false;
    }
}

function logout() {
    authToken = null;
    currentUser = null;
    isAuthenticated = false;
    localStorage.removeItem('auth_token');
    cart = [];
    wishlist = [];
    updateAuthUI();
    window.location.href = '/';
}

// Modal Functions
function initModals() {
    // Close modal when clicking outside
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(this.id);
            }
        });
    });
    
    // Close buttons
    document.querySelectorAll('.modal-close').forEach(btn => {
        btn.addEventListener('click', function() {
            const modal = this.closest('.modal');
            closeModal(modal.id);
        });
    });
}

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// Product Functions
async function loadProducts(category = null, search = null) {
    try {
        let url = `${API_BASE}/products`;
        const params = new URLSearchParams();
        
        if (category) params.append('category', category);
        if (search) params.append('search', search);
        
        if (params.toString()) url += '?' + params.toString();
        
        const response = await fetch(url);
        const data = await response.json();
        
        if (response.ok) {
            displayProducts(data.data || data);
        }
    } catch (error) {
        console.error('Error loading products:', error);
    }
}

function displayProducts(products) {
    const container = document.getElementById('productsGrid');
    if (!container) return;
    
    container.innerHTML = '';
    
    products.forEach(product => {
        const productCard = createProductCard(product);
        container.appendChild(productCard);
    });
}

function createProductCard(product) {
    const card = document.createElement('div');
    card.className = 'product-card';
    card.style.cursor = 'pointer';
    card.onclick = function() {
        window.location.href = `/product/${product.slug}`;
    };
    
    const price = parseFloat(product.price).toLocaleString('en-LK', {
        style: 'currency',
        currency: 'LKR'
    });
    
    card.innerHTML = `
        <div class="product-image">
            <img src="${product.image_url || '/img/placeholder.jpg'}" alt="${product.name}">
            ${product.is_new ? '<span class="product-badge">New</span>' : ''}
        </div>
        <div class="product-info">
            <div class="product-category">${product.category?.name || 'Uncategorized'}</div>
            <h3 class="product-title">${product.name}</h3>
            <p class="product-description">${product.description?.substring(0, 60) || ''}...</p>
            <div class="product-price" style="margin: 15px 0; font-size: 1.3rem; color: var(--primary-color); font-weight: 700;">${price}</div>
        </div>
        <div class="product-actions-bottom" style="padding: 0 20px 20px; display: flex; gap: 10px;" onclick="event.stopPropagation();">
            ${isAuthenticated ? 
                `<form action="/cart/add" method="POST" style="flex: 1;">
                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.content}">
                    <input type="hidden" name="product_id" value="${product.id}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn-cart" style="width: 100%; padding: 12px; border: none; background: var(--bg-pink); color: var(--primary-color); border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s;">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                </form>` :
                `<a href="/login" class="btn-cart" style="flex: 1; padding: 12px; border: none; background: var(--bg-pink); color: var(--primary-color); border-radius: 8px; text-decoration: none; font-weight: 600; text-align: center; display: block;">
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                </a>`
            }
        </div>
    `;
    
    return card;
}

async function loadCategories() {
    try {
        const response = await fetch(`${API_BASE}/categories`);
        const data = await response.json();
        
        if (response.ok) {
            displayCategories(data.data || data);
        }
    } catch (error) {
        console.error('Error loading categories:', error);
    }
}

function displayCategories(categories) {
    const container = document.getElementById('categoriesGrid');
    if (!container) return;
    
    container.innerHTML = '';
    
    categories.forEach(category => {
        const card = document.createElement('div');
        card.className = 'category-card';
        card.onclick = () => filterByCategory(category.slug);
        
        card.innerHTML = `
            <img src="${category.image_url || '/img/category-placeholder.jpg'}" alt="${category.name}" class="category-image">
            <div class="category-content">
                <h3>${category.name} <i class="fas fa-arrow-right"></i></h3>
            </div>
        `;
        
        container.appendChild(card);
    });
}

function filterByCategory(categorySlug) {
    window.location.href = `/products?category=${categorySlug}`;
}

// Cart Functions
function initCart() {
    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
        updateCartUI();
    }
}

async function addToCart(productId) {
    if (!isAuthenticated) {
        openModal('loginModal');
        return;
    }
    
    try {
        const response = await fetch(`${API_BASE}/cart`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1
            })
        });
        
        if (response.ok) {
            showNotification('Product added to cart!', 'success');
            fetchCart();
        } else {
            showNotification('Failed to add to cart', 'error');
        }
    } catch (error) {
        console.error('Error adding to cart:', error);
        showNotification('An error occurred', 'error');
    }
}

async function fetchCart() {
    if (!isAuthenticated) return;
    
    try {
        const response = await fetch(`${API_BASE}/cart`, {
            headers: {
                'Authorization': `Bearer ${authToken}`,
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            const data = await response.json();
            cart = data.data || data;
            updateCartUI();
        }
    } catch (error) {
        console.error('Error fetching cart:', error);
    }
}

function updateCartUI() {
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartCount.textContent = totalItems;
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
}

async function removeFromCart(cartItemId) {
    if (!isAuthenticated) return;
    
    try {
        const response = await fetch(`${API_BASE}/cart/${cartItemId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${authToken}`,
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            showNotification('Item removed from cart', 'success');
            fetchCart();
        }
    } catch (error) {
        console.error('Error removing from cart:', error);
    }
}

async function updateCartQuantity(cartItemId, quantity) {
    if (!isAuthenticated) return;
    
    if (quantity < 1) {
        removeFromCart(cartItemId);
        return;
    }
    
    try {
        const response = await fetch(`${API_BASE}/cart/${cartItemId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity })
        });
        
        if (response.ok) {
            fetchCart();
        }
    } catch (error) {
        console.error('Error updating cart:', error);
    }
}

// Wishlist Functions
function initWishlist() {
    const savedWishlist = localStorage.getItem('wishlist');
    if (savedWishlist) {
        wishlist = JSON.parse(savedWishlist);
        updateWishlistUI();
    }
}

function addToWishlist(productId) {
    if (!isAuthenticated) {
        openModal('loginModal');
        return;
    }
    
    if (!wishlist.includes(productId)) {
        wishlist.push(productId);
        localStorage.setItem('wishlist', JSON.stringify(wishlist));
        updateWishlistUI();
        showNotification('Added to wishlist!', 'success');
    }
}

function removeFromWishlist(productId) {
    wishlist = wishlist.filter(id => id !== productId);
    localStorage.setItem('wishlist', JSON.stringify(wishlist));
    updateWishlistUI();
    showNotification('Removed from wishlist', 'success');
}

function updateWishlistUI() {
    const wishlistCount = document.querySelector('.wishlist-count');
    if (wishlistCount) {
        wishlistCount.textContent = wishlist.length;
    }
}

// Search Function
function searchProducts(query) {
    loadProducts(null, query);
}

// Buy Now Function
function buyNow(productId) {
    if (!isAuthenticated) {
        openModal('loginModal');
        return;
    }
    
    addToCart(productId).then(() => {
        window.location.href = '/checkout';
    });
}

// Notification System
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#4CAF50' : type === 'error' ? '#f44336' : '#2196F3'};
        color: white;
        padding: 15px 25px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        z-index: 10000;
        animation: slideIn 0.3s;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Form Handlers
document.addEventListener('submit', function(e) {
    if (e.target.id === 'loginForm') {
        e.preventDefault();
        const email = e.target.email.value;
        const password = e.target.password.value;
        login(email, password);
    }
    
    if (e.target.id === 'registerForm') {
        e.preventDefault();
        const name = e.target.name.value;
        const email = e.target.email.value;
        const password = e.target.password.value;
        const confirmPassword = e.target.confirm_password.value;
        
        if (password !== confirmPassword) {
            showNotification('Passwords do not match', 'error');
            return;
        }
        
        register(name, email, password);
    }
});

// Search Input Handler
const searchInput = document.querySelector('.search-box input');
if (searchInput) {
    let searchTimeout;
    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            searchProducts(e.target.value);
        }, 500);
    });
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;

// Toggle User Menu
function toggleUserMenu() {
    const menu = document.getElementById('userMenu');
    if (menu) {
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }
}

// Close user menu when clicking outside
document.addEventListener('click', function(event) {
    const userDropdown = document.querySelector('.user-dropdown');
    const userMenu = document.getElementById('userMenu');
    if (userDropdown && userMenu && !userDropdown.contains(event.target)) {
        userMenu.style.display = 'none';
    }
});

// Scroll Effects
function initScrollEffects() {
    const header = document.querySelector('header');
    if (!header) return;
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            header.style.boxShadow = '0 4px 20px rgba(155, 93, 143, 0.15)';
        } else {
            header.style.boxShadow = 'none';
        }
    });
}

// Animations on scroll
function initAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe all cards
    const cards = document.querySelectorAll('.product-card, .feature-card, .category-card, .testimonial-card');
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
        observer.observe(card);
    });
}
document.head.appendChild(style);
