<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController; // <--- CRITICAL IMPORT
use App\Http\Controllers\SellerProductController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'categories' => Category::inRandomOrder()->limit(6)->get(),
        'featuredProducts' => Product::with('category')->latest()->take(8)->get(),
    ]);
})->name('home');

Route::get('/p/{slug}', [ProductController::class, 'show'])->name('products.show');

// --- AUTHENTICATED GROUP ---
// Includes 'prevent-back-history' to fix the logout/back-button issue
Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    // 1. Dashboard Redirect Logic (Customer)
    Route::get('/dashboard', [DashboardController::class, 'client'])
        ->middleware(['verified'])
        ->name('dashboard');

    // 2. Profile Routes (CRITICAL: These names must match what Ziggy expects)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 3. Seller Dashboard
    Route::middleware(['role:seller'])->group(function () {

        Route::get('/seller/dashboard', [DashboardController::class, 'seller'])
            ->name('seller.dashboard');

        // NEW: Product Routes
        Route::get('/seller/products/create', [SellerProductController::class, 'create'])
            ->name('seller.products.create');

        Route::post('/seller/products', [SellerProductController::class, 'store'])
            ->name('seller.products.store');
    });

    // 4. Admin Dashboard
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
            ->name('admin.dashboard');
    });

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

    // NEW CHECKOUT ROUTE
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

});

require __DIR__.'/auth.php';
