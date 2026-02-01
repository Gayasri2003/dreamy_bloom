<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PayHere Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for PayHere payment gateway integration
    |
    */

    'merchant_id' => env('PAYHERE_MERCHANT_ID'),
    'merchant_secret' => env('PAYHERE_MERCHANT_SECRET'),
    
    // Mode: 'sandbox' or 'live'
    'mode' => env('PAYHERE_MODE', 'sandbox'),
    
    // PayHere URLs
    'sandbox_url' => 'https://sandbox.payhere.lk/pay/checkout',
    'live_url' => 'https://www.payhere.lk/pay/checkout',
    
    // Currency
    'currency' => env('PAYHERE_CURRENCY', 'LKR'),
    
    // Return URLs
    'return_url' => env('APP_URL') . '/payment/payhere/return',
    'cancel_url' => env('APP_URL') . '/payment/payhere/cancel',
    'notify_url' => env('APP_URL') . '/payment/payhere/notify',
];
