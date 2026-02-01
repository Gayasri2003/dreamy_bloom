<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Initiate PayHere payment
     */
    public function initiate(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'phone' => 'required|string',
        ]);

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

        // Calculate total
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        // Store order data in session for later processing
        session([
            'pending_order' => [
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'shipping_address' => $validated['shipping_address'],
                'phone' => $validated['phone'],
                'cart_items' => $cartItems->toArray(),
            ]
        ]);

        // Generate unique order ID for PayHere
        $orderId = 'ORD-' . strtoupper(uniqid());
        session(['pending_order_id' => $orderId]);

        // Prepare PayHere payment data
        $paymentData = [
            'merchant_id' => config('payhere.merchant_id'),
            'return_url' => config('payhere.return_url'),
            'cancel_url' => config('payhere.cancel_url'),
            'notify_url' => config('payhere.notify_url'),
            'order_id' => $orderId,
            'items' => 'Order #' . $orderId,
            'currency' => config('payhere.currency'),
            'amount' => number_format($total, 2, '.', ''),
            'first_name' => auth()->user()->name,
            'last_name' => '',
            'email' => auth()->user()->email,
            'phone' => $validated['phone'],
            'address' => $validated['shipping_address'],
            'city' => 'Colombo',
            'country' => 'Sri Lanka',
        ];

        // Generate hash for security
        $merchantSecret = config('payhere.merchant_secret');
        $hashedSecret = strtoupper(md5($merchantSecret));
        
        $hash = strtoupper(
            md5(
                $paymentData['merchant_id'] . 
                $paymentData['order_id'] . 
                $paymentData['amount'] . 
                $paymentData['currency'] . 
                $hashedSecret
            )
        );

        $paymentData['hash'] = $hash;

        // Get PayHere URL based on mode
        $paymentUrl = config('payhere.mode') === 'live' 
            ? config('payhere.live_url') 
            : config('payhere.sandbox_url');

        return view('checkout.payment-processing', compact('paymentData', 'paymentUrl'));
    }

    /**
     * Handle PayHere notification (Server-side IPN)
     */
    public function notify(Request $request)
    {
        Log::info('PayHere Notify:', $request->all());

        $merchantSecret = config('payhere.merchant_secret');
        $hashedSecret = strtoupper(md5($merchantSecret));

        // Verify hash
        $merchantId = $request->merchant_id;
        $orderId = $request->order_id;
        $amount = $request->payhere_amount;
        $currency = $request->payhere_currency;
        $statusCode = $request->status_code;
        $md5Hash = $request->md5sig;

        $localHash = strtoupper(
            md5(
                $merchantId . 
                $orderId . 
                $amount . 
                $currency . 
                $statusCode . 
                $hashedSecret
            )
        );

        if ($localHash !== $md5Hash) {
            Log::error('PayHere Hash Mismatch', [
                'local' => $localHash,
                'received' => $md5Hash
            ]);
            return response('Hash verification failed', 400);
        }

        // Check if order already exists
        $existingOrder = Order::where('order_number', $orderId)->first();
        if ($existingOrder) {
            Log::info('Order already exists: ' . $orderId);
            return response('OK', 200);
        }

        // Payment successful
        if ($statusCode == 2) {
            DB::beginTransaction();
            try {
                // Get pending order from database or session
                $pendingOrder = session('pending_order');
                
                if (!$pendingOrder) {
                    Log::error('No pending order found for: ' . $orderId);
                    return response('No pending order', 400);
                }

                // Create order
                $order = Order::create([
                    'user_id' => $pendingOrder['user_id'],
                    'order_number' => $orderId,
                    'total_amount' => $pendingOrder['total_amount'],
                    'status' => 'processing',
                    'shipping_address' => $pendingOrder['shipping_address'],
                    'payment_method' => 'payhere',
                    'payment_status' => 'paid',
                    'payment_id' => $request->payment_id,
                    'payment_response' => $request->all(),
                ]);

                // Create order items and update stock
                foreach ($pendingOrder['cart_items'] as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['product']['price'],
                    ]);

                    // Update product stock
                    DB::table('products')
                        ->where('id', $item['product_id'])
                        ->decrement('stock', $item['quantity']);
                }

                // Clear cart
                Cart::where('user_id', $pendingOrder['user_id'])->delete();

                DB::commit();

                Log::info('Order created successfully: ' . $orderId);
                return response('OK', 200);

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Order creation failed: ' . $e->getMessage());
                return response('Order creation failed', 500);
            }
        } else {
            Log::warning('Payment not successful. Status: ' . $statusCode);
            return response('Payment not successful', 200);
        }
    }

    /**
     * Handle user return from PayHere
     */
    public function return(Request $request)
    {
        $orderId = session('pending_order_id');
        
        // Wait a moment for the notify callback to process
        sleep(2);

        // Check if order was created
        $order = Order::where('order_number', $orderId)->first();

        if ($order) {
            // Clear session
            session()->forget(['pending_order', 'pending_order_id']);
            
            return redirect()->route('order.success', $order->id)
                ->with('success', 'Payment successful! Your order has been placed.');
        } else {
            return redirect()->route('checkout.index')
                ->with('error', 'Payment is being processed. Please check your orders shortly.');
        }
    }

    /**
     * Handle payment cancellation
     */
    public function cancel(Request $request)
    {
        // Clear pending order from session
        session()->forget(['pending_order', 'pending_order_id']);

        return redirect()->route('checkout.index')
            ->with('error', 'Payment was cancelled. Please try again.');
    }
}
