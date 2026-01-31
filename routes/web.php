<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Page d'accueil publique
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route Dashboard Standard (Client/Acheteur)
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profil commun à tous les utilisateurs connectés
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- ESPACE VENDEUR ---
Route::middleware(['auth', 'role:seller'])->group(function () {
    // Note : On utilise une fonction anonyme en attendant de créer le SellerController
    Route::get('/seller/dashboard', function () {
        return Inertia::render('Seller/Dashboard');
    })->name('seller.dashboard');
});

// --- ESPACE ADMIN ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return Inertia::render('Admin/Dashboard'); // Assurez-vous d'avoir ce fichier
    })->name('admin.dashboard');
});

require __DIR__.'/auth.php';
