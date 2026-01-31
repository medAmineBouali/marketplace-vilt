<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function client()
    {
        $orders = Order::with(['items.product']) // Eager load items and their product details
        ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return Inertia::render('Dashboard', [
            'orders' => $orders
        ]);
    }

    // 2. SELLER DASHBOARD
    // Fetches the seller's shop and their products
    public function seller()
    {
        $user = Auth::user();

        // Ensure the relationship exists in User model: public function shop() { return $this->hasOne(Shop::class); }
        $shop = Shop::with(['products' => function($query) {
            $query->withCount('reviews'); // Useful to see review counts on dashboard
        }])
            ->where('user_id', $user->id)
            ->first();

        return Inertia::render('Seller/Dashboard', [
            'shop' => $shop
        ]);
    }

    // 3. ADMIN DASHBOARD
    // Fetches global statistics
    public function admin()
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'total_users' => User::count(),
                'total_shops' => Shop::count(),
                'total_orders' => Order::count(),
                'total_revenue' => Order::sum('total_price'),
            ]
        ]);
    }
}
