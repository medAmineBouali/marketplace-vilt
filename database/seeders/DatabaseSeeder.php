<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Définir les catégories et leurs mots-clés anglais pour Unsplash
        $categoriesMap = [
            'Électronique' => 'electronics',
            'Mode'         => 'fashion',
            'Maison'       => 'home',
            'Beauté'       => 'beauty',
            'Sport'        => 'sports',
            'Jouets'       => 'toys',
        ];

        $savedCategories = [];

        // Création des catégories en base de données
        foreach ($categoriesMap as $name => $keyword) {
            // On ne passe que name et slug à la base de données
            $category = Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);

            // ASTUCE : On attache le mot-clé à l'objet PHP en mémoire SEULEMENT (pas en base)
            // pour pouvoir s'en servir plus bas dans la boucle des produits
            $category->unsplash_keyword = $keyword;

            $savedCategories[] = $category;
        }

        // 2. Créer les Utilisateurs Fixes
        // Admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Client
        User::factory()->create([
            'name' => 'Amine Client',
            'email' => 'customer@test.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        // Vendeur Principal
        $mainSeller = User::factory()->create([
            'name' => 'Jean Vendeur',
            'email' => 'seller@test.com',
            'password' => bcrypt('password'),
            'role' => 'seller',
        ]);

        // Créer 4 autres vendeurs
        $otherSellers = User::factory(4)->create(['role' => 'seller']);

        $allSellers = $otherSellers->push($mainSeller);

        // 3. Boucle sur chaque vendeur
        foreach ($allSellers as $seller) {

            $shop = Shop::create([
                'user_id' => $seller->id,
                'name' => 'Boutique de ' . $seller->name,
                'slug' => Str::slug('boutique-' . $seller->name . '-' . $seller->id),
                'description' => 'La meilleure boutique pour trouver vos produits favoris.',
                'is_active' => true,
            ]);

            // Créer 15 produits pour cette boutique
            for ($i = 1; $i <= 15; $i++) {
                // Choisir une catégorie au hasard parmi celles créées
                $randomCategory = $savedCategories[array_rand($savedCategories)];

                $productName = fake()->words(3, true);

                // On récupère le mot-clé qu'on a attaché temporairement à l'objet
                $imageKeyword = $randomCategory->unsplash_keyword;

                // URL avec signature aléatoire pour éviter les doublons de cache
                $imageUrl = "https://source.unsplash.com/600x600/?{$imageKeyword}&sig=" . rand(1, 10000);

                Product::create([
                    'shop_id' => $shop->id,
                    'category_id' => $randomCategory->id,
                    'name' => ucfirst($productName),
                    'slug' => Str::slug($productName) . '-' . Str::random(6),
                    'description' => fake()->paragraph(3),
                    'price' => fake()->randomFloat(2, 10, 500),
                    'stock_quantity' => fake()->numberBetween(0, 100),
                    'image' => $imageUrl,
                ]);
            }
        }
    }
}
