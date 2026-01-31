<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CartController extends Controller
{
    // 1. Display the Cart Page
    public function index()
    {
        // Get cart from session (default to empty array)
        $cart = session()->get('cart', []);

        // Fetch product details from DB for items in cart
        // We only stored IDs in session, now we need Names, Prices, Images
        $products = Product::whereIn('id', array_keys($cart))->get();

        // Merge Quantity from Session into the Product Objects
        $cartItems = $products->map(function ($product) use ($cart) {
            $product->quantity = $cart[$product->id];
            $product->total_price = $product->price * $cart[$product->id];
            return $product;
        });

        // Calculate Grand Total
        $grandTotal = $cartItems->sum('total_price');

        return Inertia::render('Cart', [
            'cartItems' => $cartItems,
            'grandTotal' => $grandTotal,
        ]);
    }

    // 2. Add Item to Cart
    public function add(Request $request)
    {
        $id = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $cart = session()->get('cart', []);

        // If item exists, add to quantity. If not, set quantity.
        if (isset($cart[$id])) {
            $cart[$id] += $quantity;
        } else {
            $cart[$id] = $quantity;
        }

        session()->put('cart', $cart);

        return back()->with('message', 'Produit ajouté au panier !');
    }

    // 3. Remove Item
    public function remove(Request $request)
    {
        $id = $request->input('product_id');
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back();
    }

    // 4. Checkout (Create the Order)
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Votre panier est vide.');
        }

        // Use a Transaction to ensure everything is saved or nothing is saved
        DB::transaction(function () use ($cart) {
            $user = Auth::user();

            // 1. Calculate Total and Fetch Products
            $products = Product::whereIn('id', array_keys($cart))->get();
            $totalPrice = 0;

            foreach ($products as $product) {
                $qty = $cart[$product->id];
                $totalPrice += $product->price * $qty;
            }

            // 2. Create the Order
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'status' => 'pending',        // Default status
                'payment_status' => 'paid',   // Simulated payment for uni project
                'transaction_id' => 'TXN-' . Str::upper(Str::random(10)),
            ]);

            // 3. Create Order Items
            foreach ($products as $product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $cart[$product->id],
                    'price' => $product->price, // Save price at moment of purchase
                ]);

                // Optional: Decrease Stock
                $product->decrement('stock_quantity', $cart[$product->id]);
            }

            // 4. Clear the Cart
            session()->forget('cart');
        });

        return redirect()->route('dashboard')->with('success', 'Commande validée avec succès !');
    }
}
