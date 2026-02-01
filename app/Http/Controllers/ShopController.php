<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::with('category')
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();
        
        // Get recent products (most recently added)
        $recentProducts = Product::with('category')
            ->where('is_active', true)
            ->latest('created_at')
            ->take(8)
            ->get();
            
        $categories = Category::where('is_active', true)->get();
        $testimonials = Testimonial::where('is_active', true)->get();
        
        return view('shop.home', compact('featuredProducts', 'recentProducts', 'categories', 'testimonials'));
    }
    
    public function products(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);
        
        // Filter by category if provided
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        // Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $products = $query->latest()->paginate(12);
        $categories = Category::where('is_active', true)->get();
        
        return view('shop.products', compact('products', 'categories'));
    }
    
    public function productDetail($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();
            
        return view('shop.product-detail', compact('product', 'relatedProducts'));
    }
    
    public function about()
    {
        return view('shop.about');
    }
    
    public function contact()
    {
        return view('shop.contact');
    }
    
    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'message' => 'required|string',
        ]);
        
        \App\Models\Contact::create($validated);
        
        return redirect()->back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
    
    public function testimonials()
    {
        $testimonials = Testimonial::where('is_active', true)->get();
        return view('shop.testimonials', compact('testimonials'));
    }
}
