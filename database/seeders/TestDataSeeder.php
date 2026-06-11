<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Delivery;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // Récupérer ou créer l'utilisateur admin
        $user = User::firstOrCreate(
            ['email' => 'kalmi2026@gmail.com'],
            [
                'name' => 'Kalmi Admin',
                'password' => bcrypt('Kalmi2026'),
                'role' => 'admin'
            ]
        );

        // Créer une catégorie
        $category = Category::firstOrCreate(
            ['name' => 'Produits Test']
        );

        // Créer des produits
        $product1 = Product::firstOrCreate(
            ['name' => 'Produit A'],
            [
                'category_id' => $category->id,
                'purchase_price' => 1000,
                'selling_price' => 1500,
                'stock_quantity' => 50,
                'alert_threshold' => 10
            ]
        );

        $product2 = Product::firstOrCreate(
            ['name' => 'Produit B'],
            [
                'category_id' => $category->id,
                'purchase_price' => 2000,
                'selling_price' => 3000,
                'stock_quantity' => 30,
                'alert_threshold' => 5
            ]
        );

        // Créer quelques commandes avec dates différentes
        for ($i = 0; $i < 5; $i++) {
            $order = Order::create([
                'user_id' => $user->id,
                'invoice_number' => 'INV-' . str_pad(($i + 1), 4, '0', STR_PAD_LEFT),
                'total_amount' => ($i + 1) * 4500,
                'customer_name' => 'Client ' . ($i + 1),
                'customer_phone' => '012345678' . $i,
                'created_at' => now()->subDays($i),
                'updated_at' => now()->subDays($i)
            ]);

            // Ajouter des items à la commande
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product1->id,
                'quantity' => $i + 1,
                'unit_price' => $product1->selling_price,
                'purchase_price_snap' => $product1->purchase_price
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product2->id,
                'quantity' => 1,
                'unit_price' => $product2->selling_price,
                'purchase_price_snap' => $product2->purchase_price
            ]);

            // Créer une livraison pour chaque commande
            Delivery::create([
                'order_id' => $order->id,
                'delivery_address' => 'Adresse de livraison ' . ($i + 1) . ', Rue Test, Ville',
                'status' => $i < 3 ? 'En cours de livraison' : 'Livré',
                'created_at' => now()->subDays($i),
                'updated_at' => now()->subDays($i)
            ]);
        }

        $this->command->info('Données de test créées avec succès !');
    }
}
