<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KalmiAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'kalmi2026@gmail.com'],
            [
                'name'     => 'Kalmi Admin',
                'email'    => 'kalmi2026@gmail.com',
                'password' => Hash::make('Kalmi2026'),
                'role'     => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Admin Kalmi créé avec succès !');
        $this->command->info('   Email    : kalmi2026@gmail.com');
        $this->command->info('   Mot de passe : Kalmi2026');
        $this->command->info('   Rôle     : admin');
    }
}
