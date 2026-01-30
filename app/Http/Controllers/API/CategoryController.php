<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->get();

        $categories->transform(function ($cat) {
            $cat->image_url = $cat->image ? url(Storage::url($cat->image)) : null;
            return $cat;
        });

        return response()->json($categories);
    }

    public function show($slug)
    {
        $category = Category::with(['products' => function($query) {
            $query->where('is_active', true);
        }])->where('slug', $slug)->firstOrFail();

        $category->image_url = $category->image ? url(Storage::url($category->image)) : null;

        return response()->json($category);
    }
}
