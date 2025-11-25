<?php

use App\Http\Controllers\AchatController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\ProduitController;



// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');


    // Routes pour la configuration du mot de passe
    Route::get('/email', [AuthController::class, 'showSetPasswordForm'])->name('email');
    Route::post('/email-store', [AuthController::class, 'storeEmail'])->name('storeRequest');

    Route::post('set_password', [AuthController::class, 'storePassword'])->name('password.reset'); // 
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
// role-specific dashboards and admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('save');
    //users
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
     Route::delete('/user/{user}/delete', [UserController::class, 'delete']);
    Route::get('/user/{user}/edit', [UserController::class, 'edit']);
    Route::patch('/user/{user}/update', [UserController::class, 'update']);
});

Route::middleware(['auth', 'manager'])->group(function () {
    Route::get('/manager/dashboard', [AuthController::class, 'managerDashboard'])->name('manager.dashboard');
});

Route::middleware(['auth', 'caisse'])->group(function () {
    Route::get('/caisse/dashboard', [AuthController::class, 'caisseDashboard'])->name('caisse.dashboard');
});

// Shared resource routes protected by Gates
Route::middleware(['auth','can:see-achats'])->group(function () {
    Route::get('/achats', [AchatController::class, 'index'])->name('achats.index');
    Route::post('/achats/create', [AchatController::class, 'store'])->name('achats.store');
});

Route::middleware(['auth','can:see-ventes'])->group(function () {
    Route::get('/ventes', [VenteController::class, 'index'])->name('ventes.index');
    Route::post('/vente/create', [VenteController::class, 'store'])->name('ventes.store');
});

// Produits: afficher et créer
Route::middleware(['auth'])->group(function () {
    Route::get('/produits', [ProduitController::class, 'index'])->name('produits.index');
    Route::get('/produits/create', [ProduitController::class, 'create'])->name('produits.create');
    Route::post('/produits', [ProduitController::class, 'store'])->name('produits.store');
});
