<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function show($slug)
    {
        // Fetch product with relations
        $product = Product::with(['shop.user', 'category', 'reviews.user'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Calculate average rating manually (or use the attribute if you added it)
        $product->average_rating = $product->reviews->avg('rating');

        return Inertia::render('Products/Show', [
            'product' => $product,
            // Check if related products exist, otherwise empty
            'relatedProducts' => Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->take(4)
                ->get()
        ]);
    }
}
