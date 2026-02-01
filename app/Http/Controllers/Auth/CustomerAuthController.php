<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login-customer');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
            'role' => 'customer',
        ]);

        // Create API token for the user
        $user->createToken('auth_token');

        Auth::login($user);
        
        // Check if there's a pending cart intent
        if (session()->has('cart_intent')) {
            $cartIntent = session('cart_intent');
            
            // Add the item to cart
            $product = \App\Models\Product::find($cartIntent['product_id']);
            if ($product && $product->stock >= $cartIntent['quantity']) {
                \App\Models\Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $cartIntent['product_id'],
                    'quantity' => $cartIntent['quantity'],
                ]);
                
                session()->forget('cart_intent');
                return redirect()->route('shop.home')->with('success', 'Account created! Product added to your cart.');
            }
            
            session()->forget('cart_intent');
        }

        return redirect()->route('shop.home')->with('success', 'Account created successfully!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            // Create API token for the user
            Auth::user()->createToken('auth_token');
            
            // Check if there's a pending cart intent
            if (session()->has('cart_intent')) {
                $cartIntent = session('cart_intent');
                
                // Add the item to cart
                $product = \App\Models\Product::find($cartIntent['product_id']);
                if ($product && $product->stock >= $cartIntent['quantity']) {
                    $cartItem = \App\Models\Cart::where('user_id', Auth::id())
                        ->where('product_id', $cartIntent['product_id'])
                        ->first();
                    
                    if ($cartItem) {
                        $cartItem->quantity += $cartIntent['quantity'];
                        $cartItem->save();
                    } else {
                        \App\Models\Cart::create([
                            'user_id' => Auth::id(),
                            'product_id' => $cartIntent['product_id'],
                            'quantity' => $cartIntent['quantity'],
                        ]);
                    }
                    
                    session()->forget('cart_intent');
                    return redirect()->intended(route('shop.home'))->with('success', 'Welcome back! Product added to your cart.');
                }
                
                session()->forget('cart_intent');
            }
            
            return redirect()->intended(route('shop.home'))->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('shop.home')->with('success', 'Logged out successfully!');
    }
}
