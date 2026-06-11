<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('deliveries', function (Blueprint $table) {
            $table->string('status')->default('En cours de traitement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('deliveries', function (Blueprint $table) {
            $table->enum('status', ['en_attente', 'en_cours', 'livre', 'annule'])->default('en_attente');
        });
    }
};
