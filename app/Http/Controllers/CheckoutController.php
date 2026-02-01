<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to checkout');
        }

        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function process(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:cod,card,bank,payhere',
            'phone' => 'required|string',
        ]);

        // If PayHere payment, redirect to PaymentController
        if ($validated['payment_method'] === 'payhere') {
            return app(\App\Http\Controllers\PaymentController::class)->initiate($request);
        }

        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Check stock availability
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error', "Insufficient stock for {$item->product->name}");
            }
        }

        DB::beginTransaction();
        try {
            // Calculate total
            $total = $cartItems->sum(function($item) {
                return $item->product->price * $item->quantity;
            });

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'total_amount' => $total,
                'status' => 'pending',
                'shipping_address' => $validated['shipping_address'],
                'payment_method' => $validated['payment_method'],
            ]);

            // Create order items and update stock
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // Update product stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear cart
            Cart::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('order.success', $order->id)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Order failed. Please try again.');
        }
    }

    public function success($orderId)
    {
        $order = Order::with('items.product')->where('id', $orderId)->where('user_id', auth()->id())->firstOrFail();
        return view('checkout.success', compact('order'));
    }
}
