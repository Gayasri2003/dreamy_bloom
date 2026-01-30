<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Get all orders for authenticated user
     */
    public function index(Request $request)
    {
        try {
            $orders = Order::with(['items.product'])
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $orders
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch orders',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single order details
     */
    public function show($id)
    {
        try {
            $order = Order::with(['items.product'])
                ->where('user_id', auth()->id())
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $order
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Create new order (checkout)
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'shipping_name' => 'required|string|max:255',
                'shipping_email' => 'required|email|max:255',
                'shipping_phone' => 'required|string|max:20',
                'shipping_address' => 'required|string',
                'shipping_city' => 'required|string|max:100',
                'shipping_postal_code' => 'required|string|max:10',
                'payment_method' => 'required|in:cash,payhere',
                'notes' => 'nullable|string'
            ]);

            // Get cart items
            $cartItems = Cart::with('product')
                ->where('user_id', auth()->id())
                ->get();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty'
                ], 400);
            }

            // Calculate total
            $subtotal = 0;
            foreach ($cartItems as $item) {
                if (!$item->product) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Product not found in cart'
                    ], 400);
                }
                
                if ($item->product->stock < $item->quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => "Insufficient stock for {$item->product->name}"
                    ], 400);
                }
                
                $subtotal += $item->product->price * $item->quantity;
            }

            $shipping = 500; // Fixed shipping cost
            $total = $subtotal + $shipping;

            DB::beginTransaction();

            try {
                // Create order
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'order_number' => 'ORD-' . strtoupper(uniqid()),
                    'total_amount' => $total,
                    'shipping_name' => $validated['shipping_name'],
                    'shipping_email' => $validated['shipping_email'],
                    'shipping_phone' => $validated['shipping_phone'],
                    'shipping_address' => $validated['shipping_address'],
                    'shipping_city' => $validated['shipping_city'],
                    'shipping_postal_code' => $validated['shipping_postal_code'],
                    'payment_method' => $validated['payment_method'],
                    'payment_status' => $validated['payment_method'] === 'cash' ? 'pending' : 'pending',
                    'order_status' => 'pending',
                    'notes' => $validated['notes'] ?? null,
                ]);

                // Create order items
                foreach ($cartItems as $cartItem) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                        'price' => $cartItem->product->price,
                    ]);

                    // Update product stock
                    $cartItem->product->decrement('stock', $cartItem->quantity);
                }

                // Clear cart
                Cart::where('user_id', auth()->id())->delete();

                DB::commit();

                // Load order with items
                $order->load(['items.product']);

                return response()->json([
                    'success' => true,
                    'message' => 'Order created successfully',
                    'data' => $order
                ], 201);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel order
     */
    public function cancel($id)
    {
        try {
            $order = Order::where('user_id', auth()->id())->findOrFail($id);

            if (in_array($order->order_status, ['completed', 'cancelled'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order cannot be cancelled'
                ], 400);
            }

            DB::beginTransaction();

            try {
                // Restore product stock
                foreach ($order->items as $item) {
                    $item->product->increment('stock', $item->quantity);
                }

                $order->update([
                    'order_status' => 'cancelled',
                    'payment_status' => 'cancelled'
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Order cancelled successfully',
                    'data' => $order
                ], 200);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Initialize PayHere payment
     */
    public function initializePayment(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|exists:orders,id'
            ]);

            $order = Order::where('user_id', auth()->id())
                ->findOrFail($validated['order_id']);

            if ($order->payment_method !== 'payhere') {
                return response()->json([
                    'success' => false,
                    'message' => 'This order does not use PayHere payment'
                ], 400);
            }

            // PayHere configuration
            $merchantId = config('payhere.merchant_id');
            $merchantSecret = config('payhere.merchant_secret');
            $currency = 'LKR';
            $amount = number_format($order->total_amount, 2, '.', '');

            // Generate hash
            $hash = strtoupper(
                md5(
                    $merchantId .
                    $order->order_number .
                    $amount .
                    $currency .
                    strtoupper(md5($merchantSecret))
                )
            );

            $paymentData = [
                'merchant_id' => $merchantId,
                'return_url' => route('api.payment.return'),
                'cancel_url' => route('api.payment.cancel'),
                'notify_url' => route('payment.payhere.notify'),
                'order_id' => $order->order_number,
                'items' => 'Order ' . $order->order_number,
                'currency' => $currency,
                'amount' => $amount,
                'first_name' => explode(' ', $order->shipping_name)[0],
                'last_name' => explode(' ', $order->shipping_name)[1] ?? '',
                'email' => $order->shipping_email,
                'phone' => $order->shipping_phone,
                'address' => $order->shipping_address,
                'city' => $order->shipping_city,
                'country' => 'Sri Lanka',
                'hash' => $hash,
            ];

            return response()->json([
                'success' => true,
                'data' => [
                    'payment_url' => config('payhere.payment_url'),
                    'payment_data' => $paymentData
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to initialize payment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify payment status
     */
    public function verifyPayment(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|exists:orders,id'
            ]);

            $order = Order::where('user_id', auth()->id())
                ->findOrFail($validated['order_id']);

            return response()->json([
                'success' => true,
                'data' => [
                    'payment_status' => $order->payment_status,
                    'order_status' => $order->order_status,
                    'order' => $order
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify payment',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
