<?php

use App\Http\Controllers\AuteurController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpruntController;
use App\Http\Controllers\LivreController; // Correction du nom (majuscule)
use App\Http\Controllers\UsagerController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes pour les catégories avec paramètre en français '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'
Route::resource('categories', CategorieController::class)->parameters([
    'categories' => 'categorie'
]);

// Routes pour les auteurs avec paramètre en français
Route::resource('auteurs', AuteurController::class)->parameters([
    'auteurs' => 'auteur'
]);

// Routes pour les livres avec paramètre en français
Route::resource('livres', LivreController::class)->parameters([
    'livres' => 'livre'
]);

// Routes pour les emprunts avec paramètre en français
Route::resource('emprunts', EmpruntController::class)->parameters([
    'emprunts' => 'emprunt'
]);
Route::post('/emprunts/emprunt}/retourner', [EmpruntController::class, 'retourner'])->name('emprunts.retourner');
// Remplacer la route des réservations par celle des usagers
Route::resource('usagers', UsagerController::class)->parameters([
    'usagers' => 'usager'
]);

require __DIR__ . '/auth.php';
