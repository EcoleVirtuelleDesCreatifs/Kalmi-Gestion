<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Delivery;

class ClientDataSeeder extends Seeder
{
    public function run()
    {
        // Récupérer l'utilisateur admin
        $user = User::where('email', 'kalmi2026@gmail.com')->first();
        
        if (!$user) {
            $this->command->error('Utilisateur admin non trouvé!');
            return;
        }

        // Créer la catégorie Vêtements
        $categoryVetements = Category::create([
            'name' => 'Vêtements'
        ]);

        // Créer des produits pour l'achat de vêtements
        // On va créer plusieurs articles pour représenter l'achat de 2.350.000F
        $products = [
            ['name' => 'Lot Vêtements Été', 'purchase_price' => 800000, 'selling_price' => 1200000, 'stock' => 50],
            ['name' => 'Lot Vêtements Hiver', 'purchase_price' => 750000, 'selling_price' => 1100000, 'stock' => 40],
            ['name' => 'Accessoires Mode', 'purchase_price' => 500000, 'selling_price' => 750000, 'stock' => 100],
            ['name' => 'Chaussures Diverses', 'purchase_price' => 300000, 'selling_price' => 450000, 'stock' => 30]
        ];

        $createdProducts = [];
        foreach ($products as $product) {
            $createdProduct = Product::create([
                'category_id' => $categoryVetements->id,
                'name' => $product['name'],
                'purchase_price' => $product['purchase_price'],
                'selling_price' => $product['selling_price'],
                'stock_quantity' => $product['stock'],
                'alert_threshold' => 10,
                'created_at' => '2026-04-20 10:00:00',
                'updated_at' => '2026-04-20 10:00:00'
            ]);
            $createdProducts[] = $createdProduct;
        }

        // Créer une commande pour l'achat (représentant l'achat des vêtements)
        // Note: Dans ce système, les commandes représentent des ventes, pas des achats
        // Mais on peut créer une commande pour suivre l'investissement initial
        
        // VENTE DU 29 AVRIL : 98.500F
        $order29Avril = Order::create([
            'user_id' => $user->id,
            'invoice_number' => 'INV-29042026',
            'total_amount' => 98500,
            'customer_name' => 'Client 29 Avril',
            'customer_phone' => '0123456789',
            'created_at' => '2026-04-29 14:30:00',
            'updated_at' => '2026-04-29 14:30:00'
        ]);

        // Ajouter des items à la commande du 29 avril
        OrderItem::create([
            'order_id' => $order29Avril->id,
            'product_id' => $createdProducts[0]->id,
            'quantity' => 1,
            'unit_price' => 98500,
            'purchase_price_snap' => $createdProducts[0]->purchase_price,
            'created_at' => '2026-04-29 14:30:00',
            'updated_at' => '2026-04-29 14:30:00'
        ]);

        // Mettre à jour le stock
        $createdProducts[0]->stock_quantity -= 1;
        $createdProducts[0]->save();

        // Créer une livraison pour la commande du 29 avril
        Delivery::create([
            'order_id' => $order29Avril->id,
            'delivery_address' => 'Adresse Client 29 Avril, Rue Principale, Ville',
            'status' => 'Livré',
            'created_at' => '2026-04-29 15:00:00',
            'updated_at' => '2026-04-29 15:00:00'
        ]);

        // VENTE DU 30 AVRIL : 288.500F
        $order30Avril = Order::create([
            'user_id' => $user->id,
            'invoice_number' => 'INV-30042026',
            'total_amount' => 288500,
            'customer_name' => 'Client 30 Avril',
            'customer_phone' => '0234567890',
            'created_at' => '2026-04-30 16:45:00',
            'updated_at' => '2026-04-30 16:45:00'
        ]);

        // Ajouter des items à la commande du 30 avril
        OrderItem::create([
            'order_id' => $order30Avril->id,
            'product_id' => $createdProducts[1]->id,
            'quantity' => 1,
            'unit_price' => 288500,
            'purchase_price_snap' => $createdProducts[1]->purchase_price,
            'created_at' => '2026-04-30 16:45:00',
            'updated_at' => '2026-04-30 16:45:00'
        ]);

        // Mettre à jour le stock
        $createdProducts[1]->stock_quantity -= 1;
        $createdProducts[1]->save();

        // Créer une livraison pour la commande du 30 avril
        Delivery::create([
            'order_id' => $order30Avril->id,
            'delivery_address' => 'Adresse Client 30 Avril, Avenue Commerciale, Ville',
            'status' => 'Livré',
            'created_at' => '2026-04-30 17:15:00',
            'updated_at' => '2026-04-30 17:15:00'
        ]);

        // Créer une catégorie pour les frais
        $categoryFrais = Category::create([
            'name' => 'Frais Operationnels'
        ]);

        // Créer un produit pour les frais de transport
        $transportProduct = Product::create([
            'category_id' => $categoryFrais->id,
            'name' => 'Frais Transport Achat Vêtements',
            'purchase_price' => 18000,
            'selling_price' => 18000,
            'stock_quantity' => 1,
            'alert_threshold' => 0,
            'created_at' => '2026-04-20 10:30:00',
            'updated_at' => '2026-04-20 10:30:00'
        ]);

        $this->command->info('Données cliente intégrées avec succès !');
        $this->command->info('Résumé:');
        $this->command->info('- Catégorie Vêtements créée avec 4 produits');
        $this->command->info('- Achat vêtements: 2.350.000F (20 Avril)');
        $this->command->info('- Transport: 18.000F (20 Avril)');
        $this->command->info('- Vente 29 Avril: 98.500F');
        $this->command->info('- Vente 30 Avril: 288.500F');
        $this->command->info('- Total ventes: 387.000F');
        $this->command->info('- Total investissement: 2.368.000F');
    }
}
