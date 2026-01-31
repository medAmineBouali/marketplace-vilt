<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
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
    public function seller()
    {
        $user = Auth::user();
        $shop = $user->shop;

        if (!$shop) {
            return Inertia::render('Seller/Dashboard', ['shop' => null, 'sales' => []]);
        }

        // Fetch Order Items related to this Shop's products
        $sales = OrderItem::with(['order.user', 'product']) // Load Customer and Product info
        ->whereHas('product', function ($query) use ($shop) {
            $query->where('shop_id', $shop->id);
        })
            ->latest()
            ->get();

        // Calculate Stats
        $totalRevenue = $sales->sum(fn($item) => $item->price * $item->quantity);
        $totalSoldItems = $sales->sum('quantity');
        $uniqueOrders = $sales->pluck('order_id')->unique()->count();

        return Inertia::render('Seller/Dashboard', [
            'shop' => $shop,
            'sales' => $sales,
            'stats' => [
                'revenue' => $totalRevenue,
                'sold_items' => $totalSoldItems,
                'orders_count' => $uniqueOrders,
            ]
        ]);
    }

    /// 3. ADMIN DASHBOARD
    public function admin()
    {
        return Inertia::render('Admin/Dashboard', [
            // Global Stats
            'stats' => [
                'total_users' => User::count(),
                'total_shops' => Shop::count(),
                'total_orders' => Order::count(),
                'total_revenue' => Order::sum('total_price'),
            ],
            // 5 Most Recent Orders (Platform-wide)
            'recentOrders' => Order::with('user')
                ->latest()
                ->take(5)
                ->get(),

            // 5 Most Recent Shops Created
            'recentShops' => Shop::with('seller')
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}
