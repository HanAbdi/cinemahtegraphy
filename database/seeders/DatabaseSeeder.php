<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default Super Admin account
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => 'password',
            'role' => 'superadmin',
            'permissions' => ['portofolio', 'penawaran', 'live_chat', 'mitra_kerja', 'superadmin_only'],
            'email_verified_at' => now(),
        ]);

        // Seed dummy data (portfolios, quotes)
        $this->call(DummyDataSeeder::class);
    }
}
