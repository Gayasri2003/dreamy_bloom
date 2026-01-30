<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_users' => User::where('role', 'customer')->count(),
            'total_categories' => Category::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_amount'),
            'recent_orders' => Order::with('user')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard.index', compact('stats'));
    }
}
