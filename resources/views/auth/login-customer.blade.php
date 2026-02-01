@extends('layouts.modern')

@section('title', 'Login - DreamyBloom')

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
        max-width: 450px;
        width: 100%;
    }
    .auth-card h2 {
        text-align: center;
        color: var(--primary-color);
        margin-bottom: 30px;
        font-size: 2rem;
    }
    .form-group {
        margin-bottom: 25px;
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
    }
    .auth-divider {
        text-align: center;
        margin: 30px 0;
        color: var(--text-gray);
        position: relative;
    }
    .auth-divider::before,
    .auth-divider::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 40%;
        height: 1px;
        background: var(--border-color);
    }
    .auth-divider::before {
        left: 0;
    }
    .auth-divider::after {
        right: 0;
    }
</style>
@endsection

@section('content')

<div class="auth-container">
    <div class="auth-card">
        <h2>Welcome Back!</h2>
        
        @if($errors->any())
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="remember" style="width: auto;">
                    <span>Remember me</span>
                </label>
                <a href="#" style="color: var(--primary-color);">Forgot Password?</a>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; padding: 15px; font-size: 1.1rem;">
                Login
            </button>
        </form>

        <div class="auth-divider">OR</div>

        <div style="text-align: center;">
            <p style="color: var(--text-gray);">Don't have an account? 
                <a href="{{ route('register') }}" style="color: var(--primary-color); font-weight: 600;">Sign Up</a>
            </p>
        </div>
    </div>
</div>

@endsection
