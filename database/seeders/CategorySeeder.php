<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and accessories',
                'slug' => 'electronics',
            ],
            [
                'name' => 'Clothing',
                'description' => 'Fashion and apparel',
                'slug' => 'clothing',
            ],
            [
                'name' => 'Books',
                'description' => 'Books and educational materials',
                'slug' => 'books',
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Home decor and gardening supplies',
                'slug' => 'home-garden',
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Sports equipment and outdoor gear',
                'slug' => 'sports-outdoors',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
