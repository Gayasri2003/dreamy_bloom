<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to view your cart');
        }

        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        // Auth middleware on route ensures user is logged in
        // No need for auth check here
        
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Insufficient stock available');
        }

        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Cannot add more items. Stock limit reached.');
            }
            
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        
        if ($cartItem->product->stock < $request->quantity) {
            return back()->with('error', 'Insufficient stock available');
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return back()->with('success', 'Cart updated!');
    }

    public function remove($id)
    {
        Cart::where('id', $id)->where('user_id', auth()->id())->delete();
        return back()->with('success', 'Item removed from cart!');
    }

    public function clear()
    {
        Cart::where('user_id', auth()->id())->delete();
        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }
}
