<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
namespace Database\Seeders;

use App\Models\User;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer des catégories de base
        $elec = Category::create(['name' => 'Électronique', 'slug' => 'electronique']);

        Category::create([
            'name' => 'Laptops',
            'slug' => 'laptops',
            'parent_id' => $elec->id
        ]);

        // 2. Créer un Administrateur
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'role' => 'admin',
        ]);

        // 3. Créer un Vendeur avec une Boutique et des Produits
        $seller = User::factory()->create([
            'name' => 'Jean Vendeur',
            'email' => 'seller@test.com',
            'role' => 'seller',
        ]);

        $shop = Shop::create([
            'user_id' => $seller->id,
            'name' => 'Tech Store',
            'slug' => 'tech-store',
            'description' => 'Le meilleur de la tech.',
            'is_active' => true,
        ]);

        // Ajouter des produits à cette boutique
        Product::create([
            'shop_id' => $shop->id,
            'category_id' => 1,
            'name' => 'Laptop Pro 2026',
            'slug' => 'laptop-pro-2026',
            'description' => 'Un ordinateur ultra puissant.',
            'price' => 1200.00,
            'stock_quantity' => 10,
        ]);

        // 4. Créer un Client standard
        User::factory()->create([
            'name' => 'Amine Client',
            'email' => 'customer@test.com',
            'role' => 'customer',
        ]);
    }
}
