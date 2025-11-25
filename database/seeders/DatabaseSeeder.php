<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Produit;
use App\Models\Achat;
use App\Models\Vente;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Produit::factory(10)->create();
         Achat::factory(10)->create();
         Vente::factory(10)->create();

        User::factory()->create([
            'name' => 'nadege',
            'email' => 'nadegedjossou299@gmail.com',
            'password' => Hash::make('nadege123'),
            'role' => 'admin',
        ]);
    }
}
