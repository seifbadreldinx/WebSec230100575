<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $electronics = Category::where('slug', 'electronics')->first();
        $clothing = Category::where('slug', 'clothing')->first();
        $books = Category::where('slug', 'books')->first();
        $homeGarden = Category::where('slug', 'home-garden')->first();
        $sports = Category::where('slug', 'sports-outdoors')->first();

        $products = [
            // Electronics
            [
                'name' => 'Wireless Headphones',
                'description' => 'High-quality wireless headphones with noise cancellation',
                'price' => 89.99,
                'stock' => 50,
                'category_id' => $electronics->id,
                'sku' => 'ELEC-001',
                'is_active' => true,
            ],
            [
                'name' => 'Smart Watch',
                'description' => 'Fitness tracking smart watch with heart rate monitor',
                'price' => 199.99,
                'stock' => 30,
                'category_id' => $electronics->id,
                'sku' => 'ELEC-002',
                'is_active' => true,
            ],
            [
                'name' => 'USB-C Cable',
                'description' => 'Fast charging USB-C cable 6ft',
                'price' => 12.99,
                'stock' => 100,
                'category_id' => $electronics->id,
                'sku' => 'ELEC-003',
                'is_active' => true,
            ],
            // Clothing
            [
                'name' => 'Cotton T-Shirt',
                'description' => '100% cotton comfortable t-shirt',
                'price' => 24.99,
                'stock' => 75,
                'category_id' => $clothing->id,
                'sku' => 'CLTH-001',
                'is_active' => true,
            ],
            [
                'name' => 'Denim Jeans',
                'description' => 'Classic fit denim jeans',
                'price' => 59.99,
                'stock' => 40,
                'category_id' => $clothing->id,
                'sku' => 'CLTH-002',
                'is_active' => true,
            ],
            // Books
            [
                'name' => 'Laravel Programming Guide',
                'description' => 'Complete guide to Laravel development',
                'price' => 49.99,
                'stock' => 25,
                'category_id' => $books->id,
                'sku' => 'BOOK-001',
                'is_active' => true,
            ],
            [
                'name' => 'Web Design Fundamentals',
                'description' => 'Learn modern web design principles',
                'price' => 39.99,
                'stock' => 20,
                'category_id' => $books->id,
                'sku' => 'BOOK-002',
                'is_active' => true,
            ],
            // Home & Garden
            [
                'name' => 'LED Desk Lamp',
                'description' => 'Adjustable LED desk lamp with USB port',
                'price' => 34.99,
                'stock' => 60,
                'category_id' => $homeGarden->id,
                'sku' => 'HOME-001',
                'is_active' => true,
            ],
            [
                'name' => 'Indoor Plant Pot',
                'description' => 'Ceramic plant pot with drainage',
                'price' => 15.99,
                'stock' => 80,
                'category_id' => $homeGarden->id,
                'sku' => 'HOME-002',
                'is_active' => true,
            ],
            // Sports
            [
                'name' => 'Yoga Mat',
                'description' => 'Non-slip yoga mat with carrying strap',
                'price' => 29.99,
                'stock' => 45,
                'category_id' => $sports->id,
                'sku' => 'SPRT-001',
                'is_active' => true,
            ],
            [
                'name' => 'Water Bottle',
                'description' => 'Stainless steel insulated water bottle 32oz',
                'price' => 19.99,
                'stock' => 90,
                'category_id' => $sports->id,
                'sku' => 'SPRT-002',
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
