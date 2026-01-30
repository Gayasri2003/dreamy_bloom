<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Product::with('category')->where('is_active', true);
            
            // Filter by category
            if ($request->has('category')) {
                $query->whereHas('category', function($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            }
            
            // Search
            if ($request->has('search')) {
                $query->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('description', 'like', '%' . $request->search . '%');
            }
            
            // Sort
            $sortBy = $request->get('sort', 'latest');
            switch ($sortBy) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                default:
                    $query->latest();
            }
            
            $perPage = $request->get('per_page', 12);
            $products = $query->paginate($perPage);
            
            return response()->json([
                'success' => true,
                'data' => $products
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($slug)
    {
        try {
            $product = Product::with('category')->where('slug', $slug)->firstOrFail();
            
            return response()->json([
                'success' => true,
                'data' => $product
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
    
    public function byCategory($slug)
    {
        try {
            $category = Category::where('slug', $slug)->firstOrFail();
            
            $products = Product::with('category')
                ->where('category_id', $category->id)
                ->where('is_active', true)
                ->latest()
                ->paginate(12);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'category' => $category,
                    'products' => $products
                ]
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
