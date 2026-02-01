@extends('layouts.modern')

@section('title', 'Register - DreamyBloom')

@section('styles')
<style>
    .auth-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        background: linear-gradient(135deg, var(--bg-pink) 0%, var(--bg-light-pink) 100%);
    }
    .auth-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        padding: 50px;
        max-width: 500px;
        width: 100%;
    }
    .auth-card h2 {
        text-align: center;
        color: var(--primary-color);
        margin-bottom: 10px;
        font-size: 2rem;
    }
    .auth-card p {
        text-align: center;
        color: var(--text-gray);
        margin-bottom: 30px;
        font-size: 0.95rem;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--text-dark);
    }
    .form-group input {
        width: 100%;
        padding: 14px;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s;
    }
    .form-group input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(155, 93, 143, 0.1);
    }
    .form-group input.error {
        border-color: #e74c3c;
    }
    .error-message {
        color: #e74c3c;
        font-size: 0.875rem;
        margin-top: 5px;
        display: block;
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }
    .auth-btn {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 10px;
    }
    .auth-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(155, 93, 143, 0.3);
    }
    .auth-divider {
        text-align: center;
        margin: 25px 0;
        position: relative;
    }
    .auth-divider::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 1px;
        background: var(--border-color);
    }
    .auth-divider span {
        background: white;
        padding: 0 15px;
        color: var(--text-gray);
        position: relative;
    }
    .auth-link {
        text-align: center;
        margin-top: 20px;
    }
    .auth-link a {
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
    }
    .auth-link a:hover {
        text-decoration: underline;
    }
    .icon-input {
        position: relative;
    }
    .icon-input i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-color);
    }
    .icon-input input {
        padding-left: 45px;
    }
    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: var(--text-gray);
    }
    .success-icon {
        color: var(--primary-color);
        font-size: 3rem;
        text-align: center;
        margin-bottom: 20px;
    }
    @media (max-width: 768px) {
        .auth-card {
            padding: 30px 20px;
        }
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="success-icon">
            <i class="fas fa-user-plus"></i>
        </div>
        <h2>Create Account</h2>
        <p>Join DreamyBloom and start your beauty journey</p>

        @if ($errors->any())
            <div style="background: #fee2e2; border-left: 4px solid #ef4444; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li style="color: #991b1b;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Full Name *</label>
                <div class="icon-input">
                    <i class="fas fa-user"></i>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="@error('name') error @enderror" 
                           value="{{ old('name') }}" 
                           placeholder="Enter your full name"
                           required 
                           autofocus>
                </div>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address *</label>
                <div class="icon-input">
                    <i class="fas fa-envelope"></i>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="@error('email') error @enderror" 
                           value="{{ old('email') }}" 
                           placeholder="your.email@example.com"
                           required>
                </div>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone Number *</label>
                <div class="icon-input">
                    <i class="fas fa-phone"></i>
                    <input type="tel" 
                           id="phone" 
                           name="phone" 
                           class="@error('phone') error @enderror" 
                           value="{{ old('phone') }}" 
                           placeholder="+94 XX XXX XXXX"
                           required>
                </div>
                @error('phone')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password *</label>
                    <div class="icon-input">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="@error('password') error @enderror" 
                               placeholder="Min. 8 characters"
                               required>
                        <span class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="togglePassword"></i>
                        </span>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password *</label>
                    <div class="icon-input">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="Confirm password"
                               required>
                        <span class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye" id="togglePasswordConfirm"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 10px; font-size: 0.875rem; color: var(--text-gray);">
                <i class="fas fa-info-circle" style="color: var(--primary-color);"></i>
                By creating an account, you agree to our Terms of Service and Privacy Policy.
            </div>

            <button type="submit" class="auth-btn">
                <i class="fas fa-user-check"></i> Create Account
            </button>
        </form>

        <div class="auth-divider">
            <span>Already have an account?</span>
        </div>

        <div class="auth-link">
            <a href="{{ route('login') }}">
                <i class="fas fa-sign-in-alt"></i> Sign in to your account
            </a>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = fieldId === 'password' ? 
        document.getElementById('togglePassword') : 
        document.getElementById('togglePasswordConfirm');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Real-time password validation
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const confirmPassword = document.getElementById('password_confirmation');
    
    if (password.length > 0 && password.length < 8) {
        this.style.borderColor = '#f59e0b';
    } else if (password.length >= 8) {
        this.style.borderColor = '#10b981';
    }
    
    if (confirmPassword.value && confirmPassword.value !== password) {
        confirmPassword.style.borderColor = '#ef4444';
    } else if (confirmPassword.value === password && password.length >= 8) {
        confirmPassword.style.borderColor = '#10b981';
    }
});

document.getElementById('password_confirmation').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    
    if (this.value !== password) {
        this.style.borderColor = '#ef4444';
    } else if (this.value === password && password.length >= 8) {
        this.style.borderColor = '#10b981';
    }
});
</script>
@endsection
