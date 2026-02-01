<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index(Request $request)
    {
        try {
            $cartItems = Cart::with('product')
                ->where('user_id', $request->user()->id)
                ->get();
            
            $total = $cartItems->sum(function($item) {
                return $item->product->price * $item->quantity;
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'items' => $cartItems,
                    'total' => $total,
                    'count' => $cartItems->count()
                ]
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
            ]);

            $product = Product::findOrFail($validated['product_id']);

            // Check stock
            $existingCart = Cart::where('user_id', $request->user()->id)
                ->where('product_id', $validated['product_id'])
                ->first();

            $newQuantity = $validated['quantity'];
            if ($existingCart) {
                $newQuantity += $existingCart->quantity;
            }

            if ($product->stock < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock available'
                ], 400);
            }

            $cartItem = Cart::updateOrCreate(
                [
                    'user_id' => $request->user()->id,
                    'product_id' => $validated['product_id'],
                ],
                ['quantity' => \DB::raw('quantity + ' . $validated['quantity'])]
            );

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully',
                'data' => $cartItem->load('product')
            ], 201);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add to cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);

            $cartItem = Cart::where('user_id', $request->user()->id)
                ->findOrFail($id);
            
            // Check stock
            if ($cartItem->product->stock < $validated['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock available'
                ], 400);
            }
            
            $cartItem->update(['quantity' => $validated['quantity']]);

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully',
                'data' => $cartItem->load('product')
            ], 200);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            Cart::where('user_id', $request->user()->id)
                ->findOrFail($id)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function clear(Request $request)
    {
        try {
            Cart::where('user_id', $request->user()->id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
