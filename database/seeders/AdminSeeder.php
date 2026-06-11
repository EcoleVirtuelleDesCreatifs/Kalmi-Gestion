<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Vendeur',
            'email' => 'vendeur@example.com',
            'password' => Hash::make('password'),
            'role' => 'vendeur',
        ]);

        $electronics = Category::create(['name' => 'Électronique']);
        $clothing = Category::create(['name' => 'Vêtements']);
        $food = Category::create(['name' => 'Alimentation']);

        Product::create([
            'category_id' => $electronics->id,
            'name' => 'Smartphone',
            'purchase_price' => 200.00,
            'selling_price' => 350.00,
            'stock_quantity' => 15,
            'alert_threshold' => 5,
        ]);

        Product::create([
            'category_id' => $electronics->id,
            'name' => 'Laptop',
            'purchase_price' => 500.00,
            'selling_price' => 800.00,
            'stock_quantity' => 8,
            'alert_threshold' => 3,
        ]);

        Product::create([
            'category_id' => $clothing->id,
            'name' => 'T-Shirt',
            'purchase_price' => 5.00,
            'selling_price' => 15.00,
            'stock_quantity' => 50,
            'alert_threshold' => 10,
        ]);

        Product::create([
            'category_id' => $clothing->id,
            'name' => 'Jeans',
            'purchase_price' => 20.00,
            'selling_price' => 45.00,
            'stock_quantity' => 30,
            'alert_threshold' => 8,
        ]);

        Product::create([
            'category_id' => $food->id,
            'name' => 'Pain',
            'purchase_price' => 0.50,
            'selling_price' => 1.50,
            'stock_quantity' => 100,
            'alert_threshold' => 20,
        ]);

        Product::create([
            'category_id' => $food->id,
            'name' => 'Lait',
            'purchase_price' => 0.80,
            'selling_price' => 1.80,
            'stock_quantity' => 60,
            'alert_threshold' => 15,
        ]);
    }
}
