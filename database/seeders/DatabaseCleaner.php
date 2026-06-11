<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseCleaner extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Désactiver les contraintes de clés étrangères
        Schema::disableForeignKeyConstraints();

        // Vider toutes les tables dans l'ordre correct
        $tables = [
            'delivery_items',
            'order_items', 
            'deliveries',
            'orders',
            'products',
            'categories',
            'users'
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
            echo "Table {$table} vidée avec succès\n";
        }

        // Réactiver les contraintes de clés étrangères
        Schema::enableForeignKeyConstraints();

        echo "Base de données vidée avec succès!\n";
    }
}
