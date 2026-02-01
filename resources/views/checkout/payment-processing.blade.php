@extends('layouts.modern')

@section('title', 'Processing Payment')

@section('content')
<div style="padding-top: 100px; min-height: 80vh; display: flex; align-items: center; justify-content: center; background: var(--bg-light-pink);">
    <div class="container">
        <div style="max-width: 500px; margin: 0 auto;">
            <div style="background: white; border-radius: 20px; padding: 50px; text-align: center; box-shadow: 0 10px 40px rgba(155, 93, 143, 0.15);">
                <div class="spinner" style="margin: 0 auto 30px;"></div>
                <h3 style="color: var(--text-dark); margin-bottom: 15px;">Redirecting to PayHere Payment Gateway</h3>
                <p style="color: var(--text-gray);">Please wait while we redirect you to complete your payment securely...</p>
                <div style="margin-top: 30px; padding-top: 30px; border-top: 1px solid var(--border-color);">
                    <i class="fas fa-lock" style="color: var(--primary-color); margin-right: 8px;"></i>
                    <small style="color: var(--text-gray);">Secured by PayHere</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PayHere Payment Form -->
<form id="payhere-form" method="POST" action="{{ $paymentUrl }}" style="display: none;">
    @foreach($paymentData as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
</form>

<script>
    // Auto-submit the form after a short delay
    setTimeout(function() {
        document.getElementById('payhere-form').submit();
    }, 1500);
</script>
@endsection
