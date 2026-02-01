<?php

namespace App\Http\Controllers\API;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::where('is_active', true)->get();
        return response()->json($testimonials);
    }
}
