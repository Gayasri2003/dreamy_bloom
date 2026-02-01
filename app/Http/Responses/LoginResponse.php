<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // Create API token for the logged-in user
        Auth::user()->createToken('auth_token');

        // Handle cart intent - add product to cart if user came from product page
        if (session()->has('cart_intent')) {
            $cartIntent = session('cart_intent');
            
            $product = \App\Models\Product::find($cartIntent['product_id']);
            if ($product && $product->stock >= $cartIntent['quantity']) {
                // Check if item already exists in cart
                $cartItem = \App\Models\Cart::where('user_id', Auth::id())
                    ->where('product_id', $cartIntent['product_id'])
                    ->first();
                
                if ($cartItem) {
                    // Update quantity if already in cart
                    $cartItem->quantity += $cartIntent['quantity'];
                    $cartItem->save();
                } else {
                    // Create new cart item
                    \App\Models\Cart::create([
                        'user_id' => Auth::id(),
                        'product_id' => $cartIntent['product_id'],
                        'quantity' => $cartIntent['quantity'],
                    ]);
                }
                
                session()->forget('cart_intent');
                return redirect()->intended(route('shop.home'))
                    ->with('success', 'Welcome back! Product added to your cart.');
            }
            
            session()->forget('cart_intent');
        }

        // Default redirect to shop home
        return redirect()->intended(route('shop.home'))
            ->with('success', 'Welcome back!');
    }
}
