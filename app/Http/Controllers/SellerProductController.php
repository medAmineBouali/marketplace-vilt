<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class SellerProductController extends Controller
{
    // Show the "Add Product" Form
    public function create()
    {
        return Inertia::render('Seller/Products/Create', [
            'categories' => Category::all(),
        ]);
    }

    // Handle the Form Submission
    public function store(Request $request)
    {
        // 1. Validate Input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'required|url', // Using URL for simplicity (Unsplash/LoremFlickr)
        ]);

        // 2. Get the Authenticated Seller's Shop
        $shop = Auth::user()->shop;

        if (!$shop) {
            return back()->with('error', 'Vous devez avoir une boutique pour vendre.');
        }

        // 3. Create the Product
        Product::create([
            'shop_id' => $shop->id,
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::random(6),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock_quantity' => $validated['stock_quantity'],
            'image' => $validated['image_url'], // Storing the URL directly
        ]);

        return redirect()->route('seller.dashboard');
    }
}
