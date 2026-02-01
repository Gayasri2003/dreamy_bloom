<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // Check if cart intent was handled during registration
        $message = session()->has('cart_added') 
            ? 'Account created! Product added to your cart.'
            : 'Account created successfully!';
        
        session()->forget('cart_added');

        // Redirect to shop home instead of dashboard
        return redirect()->route('shop.home')->with('success', $message);
    }
}
