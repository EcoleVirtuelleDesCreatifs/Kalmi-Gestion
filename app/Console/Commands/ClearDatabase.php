<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClearDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vider toutes les tables de la base de données';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Début du vidage de la base de données...');

        // Demander confirmation
        if (!$this->confirm('Êtes-vous sûr de vouloir vider TOUTE la base de données? Cette action est IRREVERSIBLE.')) {
            $this->info('Opération annulée.');
            return 0;
        }

        // Désactiver les contraintes de clés étrangères
        Schema::disableForeignKeyConstraints();

        // Vider toutes les tables dans l'ordre correct
        $tables = [
            'order_items',
            'deliveries',
            'orders',
            'products',
            'categories',
            'users'
        ];

        $progressBar = $this->output->createProgressBar(count($tables));
        $progressBar->start();

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
                $this->line(" Table {$table} vidée");
            } else {
                $this->line(" Table {$table} n'existe pas, ignorée");
            }
            $progressBar->advance();
        }

        $progressBar->finish();

        // Réactiver les contraintes de clés étrangères
        Schema::enableForeignKeyConstraints();

        $this->newLine();
        $this->info('✅ Base de données vidée avec succès!');

        return 0;
    }
}
