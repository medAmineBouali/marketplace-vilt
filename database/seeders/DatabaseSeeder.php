<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------------------------------------------------------------
        // 1. CONFIGURATION DES CATÉGORIES & IMAGES
        // -------------------------------------------------------------------------
        // J'ai mis à jour les mots-clés pour qu'ils fonctionnent bien avec LoremFlickr
        $categoriesMap = [
            'Électronique' => 'tech,electronics',
            'Mode'         => 'fashion,clothes',
            'Maison'       => 'furniture,home',
            'Beauté'       => 'makeup,beauty',
            'Sport'        => 'sports,fitness',
            'Jouets'       => 'toys,lego',
        ];

        $savedCategories = [];

        foreach ($categoriesMap as $name => $keyword) {
            $category = Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
            // On attache temporairement le mot-clé à l'objet pour l'utiliser plus bas
            $category->unsplash_keyword = $keyword;
            $savedCategories[] = $category;
        }

        // -------------------------------------------------------------------------
        // 2. CRÉATION DES UTILISATEURS FIXES (POUR VOS TESTS)
        // -------------------------------------------------------------------------

        // Admin
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Client (Amine)
        $customer = User::factory()->create([
            'name' => 'Amine Client',
            'email' => 'customer@test.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        // Vendeur Principal (Jean)
        $mainSeller = User::factory()->create([
            'name' => 'Jean Vendeur',
            'email' => 'seller@test.com',
            'password' => bcrypt('password'),
            'role' => 'seller',
        ]);

        // 4 autres vendeurs aléatoires
        $otherSellers = User::factory(4)->create(['role' => 'seller']);
        $allSellers = $otherSellers->push($mainSeller);

        $allProducts = []; // On garde une liste de tous les produits pour les commandes plus tard

        // -------------------------------------------------------------------------
        // 3. BOUCLE VENDEURS & BOUTIQUES
        // -------------------------------------------------------------------------
        foreach ($allSellers as $seller) {

            $shop = Shop::create([
                'user_id' => $seller->id,
                'name' => 'Boutique de ' . $seller->name,
                'slug' => Str::slug('boutique-' . $seller->name . '-' . $seller->id),
                'description' => 'La meilleure boutique pour trouver vos produits favoris.',
                'is_active' => true,
                'logo' => "https://ui-avatars.com/api/?name=" . urlencode($seller->name) . "&background=random",
            ]);

            // Créer 10 à 15 produits par boutique
            $numProducts = rand(10, 15);

            for ($i = 0; $i < $numProducts; $i++) {
                $randomCategory = $savedCategories[array_rand($savedCategories)];
                $productName = fake()->words(3, true);
                $imageKeyword = $randomCategory->unsplash_keyword;

                // FIX: LoremFlickr est plus fiable que source.unsplash.com
                // "random=" permet d'éviter que le navigateur mette en cache la même image partout
                $imageUrl = "https://loremflickr.com/640/480/{$imageKeyword}?random=" . rand(1, 10000);

                $product = Product::create([
                    'shop_id' => $shop->id,
                    'category_id' => $randomCategory->id,
                    'name' => ucfirst($productName),
                    'slug' => Str::slug($productName) . '-' . Str::random(6),
                    'description' => fake()->paragraph(3),
                    'price' => fake()->randomFloat(2, 10, 300),
                    'stock_quantity' => fake()->numberBetween(0, 50),
                    'image' => $imageUrl,
                ]);

                $allProducts[] = $product;

                // ---------------------------------------------------------------------
                // 4. AVIS (REVIEWS) - Ajoute de la vie à la marketplace
                // ---------------------------------------------------------------------
                // 60% de chance qu'un produit ait des avis
                if (rand(0, 100) < 60) {
                    $nbReviews = rand(1, 5);
                    for ($r = 0; $r < $nbReviews; $r++) {
                        Review::create([
                            'user_id' => User::factory()->create()->id, // Faux user random
                            'product_id' => $product->id,
                            'rating' => fake()->numberBetween(3, 5), // On reste gentil pour la démo
                            'comment' => fake()->sentence(),
                        ]);
                    }
                }
            }
        }

        // -------------------------------------------------------------------------
        // 5. COMMANDES DE TEST (POUR LE CLIENT AMINE)
        // -------------------------------------------------------------------------
        // On crée 3 commandes passées pour "Amine Client" pour tester le Dashboard
        for ($o = 0; $o < 3; $o++) {
            $order = Order::create([
                'user_id' => $customer->id,
                'total_price' => 0, // On calculera ça après
                'status' => 'paid',
                'payment_status' => 'paid',
                'transaction_id' => 'TXN-' . Str::random(10),
            ]);

            $total = 0;
            // Ajouter 2 à 4 produits aléatoires dans la commande
            $randomProducts = collect($allProducts)->random(rand(2, 4));

            foreach ($randomProducts as $prod) {
                $qty = rand(1, 3);
                $price = $prod->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $prod->id,
                    'quantity' => $qty,
                    'price' => $price, // Prix au moment de l'achat
                ]);

                $total += $price * $qty;
            }

            // Mettre à jour le total de la commande
            $order->update(['total_price' => $total]);
        }
    }
}
