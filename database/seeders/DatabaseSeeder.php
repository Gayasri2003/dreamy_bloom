<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@foody.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+1234567890',
            'address' => '123 Admin Street, New York, USA',
        ]);

        // Create Test Customer
        User::create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '+0987654321',
            'address' => '456 Customer Avenue, Los Angeles, USA',
        ]);

        // Create Categories
        $vegetableCategory = Category::create([
            'name' => 'Vegetables',
            'slug' => 'vegetables',
            'description' => 'Fresh organic vegetables from local farms',
            'image' => 'assets/img/product-1.jpg',
            'is_active' => true,
        ]);

        $fruitCategory = Category::create([
            'name' => 'Fruits',
            'slug' => 'fruits',
            'description' => 'Sweet and nutritious organic fruits',
            'image' => 'assets/img/product-2.jpg',
            'is_active' => true,
        ]);

        $freshCategory = Category::create([
            'name' => 'Fresh',
            'slug' => 'fresh',
            'description' => 'Freshly harvested organic produce',
            'image' => 'assets/img/product-3.jpg',
            'is_active' => true,
        ]);

        // Create Products for Vegetables
        $products = [
            [
                'category_id' => $vegetableCategory->id,
                'name' => 'Fresh Tomato',
                'slug' => 'fresh-tomato',
                'description' => 'Organic tomatoes grown without pesticides',
                'price' => 19.00,
                'old_price' => 29.00,
                'image' => 'assets/img/product-1.jpg',
                'stock' => 100,
                'is_new' => true,
            ],
            [
                'category_id' => $vegetableCategory->id,
                'name' => 'Fresh Broccoli',
                'slug' => 'fresh-broccoli',
                'description' => 'Green and healthy organic broccoli',
                'price' => 22.00,
                'old_price' => 32.00,
                'image' => 'assets/img/product-2.jpg',
                'stock' => 80,
                'is_new' => true,
            ],
            [
                'category_id' => $vegetableCategory->id,
                'name' => 'Fresh Carrot',
                'slug' => 'fresh-carrot',
                'description' => 'Sweet and crunchy organic carrots',
                'price' => 15.00,
                'old_price' => 25.00,
                'image' => 'assets/img/product-3.jpg',
                'stock' => 120,
                'is_new' => true,
            ],
            [
                'category_id' => $vegetableCategory->id,
                'name' => 'Fresh Cucumber',
                'slug' => 'fresh-cucumber',
                'description' => 'Crisp and refreshing organic cucumbers',
                'price' => 12.00,
                'old_price' => 20.00,
                'image' => 'assets/img/product-4.jpg',
                'stock' => 90,
                'is_new' => true,
            ],
            // Fruits
            [
                'category_id' => $fruitCategory->id,
                'name' => 'Organic Apple',
                'slug' => 'organic-apple',
                'description' => 'Sweet and juicy organic apples',
                'price' => 18.00,
                'old_price' => 28.00,
                'image' => 'assets/img/product-5.jpg',
                'stock' => 150,
                'is_new' => false,
            ],
            [
                'category_id' => $fruitCategory->id,
                'name' => 'Organic Banana',
                'slug' => 'organic-banana',
                'description' => 'Fresh organic bananas',
                'price' => 10.00,
                'old_price' => 15.00,
                'image' => 'assets/img/product-6.jpg',
                'stock' => 200,
                'is_new' => false,
            ],
            [
                'category_id' => $fruitCategory->id,
                'name' => 'Organic Orange',
                'slug' => 'organic-orange',
                'description' => 'Vitamin C rich organic oranges',
                'price' => 20.00,
                'old_price' => 30.00,
                'image' => 'assets/img/product-7.jpg',
                'stock' => 110,
                'is_new' => false,
            ],
            [
                'category_id' => $fruitCategory->id,
                'name' => 'Organic Strawberry',
                'slug' => 'organic-strawberry',
                'description' => 'Sweet and fresh organic strawberries',
                'price' => 25.00,
                'old_price' => 35.00,
                'image' => 'assets/img/product-8.jpg',
                'stock' => 60,
                'is_new' => true,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        // Create Testimonials
        $testimonials = [
            [
                'name' => 'John Doe',
                'profession' => 'Restaurant Owner',
                'message' => 'The organic vegetables from Foody are absolutely amazing! Fresh, tasty, and delivered on time every week.',
                'image' => 'assets/img/testimonial-1.jpg',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Jane Smith',
                'profession' => 'Chef',
                'message' => 'Best quality organic produce I have ever used in my kitchen. My customers love the difference in taste!',
                'image' => 'assets/img/testimonial-2.jpg',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Michael Brown',
                'profession' => 'Health Enthusiast',
                'message' => 'Switching to Foody organic products has improved my family health significantly. Highly recommended!',
                'image' => 'assets/img/testimonial-3.jpg',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Sarah Johnson',
                'profession' => 'Nutritionist',
                'message' => 'I always recommend Foody to my clients. The organic certification and quality are unmatched.',
                'image' => 'assets/img/testimonial-4.jpg',
                'rating' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonialData) {
            Testimonial::create($testimonialData);
        }
    }
}
