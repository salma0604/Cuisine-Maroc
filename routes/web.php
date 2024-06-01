<?php
use App\Http\Controllers\AcceuilController;
use App\Http\Controllers\CtrSocialite;
use App\Http\Controllers\CtrStripe;
use App\Http\Controllers\CtrUtilisateur;
use App\Http\Controllers\CuisinierController;
use Illuminate\Support\Facades\Route;

// Redirige la racine vers /Acceuil
Route::get('/', function () {
    return redirect()->route('Acceuil.index');
});
// Routes CRUD pour les cuisiniers et l'accueil
Route::resource('cuisiniers', CuisinierController::class);
Route::resource('Acceuil', AcceuilController::class);

// Routes pour la connexion et l'inscription
Route::get('/loginpage', [CtrUtilisateur::class, 'showLoginForm'])->name('loginpage');
Route::post('/loginpage', [CtrUtilisateur::class, 'login'])->name('loginpage.process');
Route::get('/logout', [CtrUtilisateur::class, 'logout'])->name('login.logout');

// Routes CRUD pour les utilisateurs (pour inscription)
Route::resource('login', CtrUtilisateur::class);

// Route pour la recherche de cuisiniers
Route::get('/search', [CuisinierController::class, 'search'])->name('cuisiniers.search');

// Routes pour Stripe
Route::post('stripe', [CtrStripe::class, 'stripe'])->name('stripe')->middleware('auth');
Route::get('success', [CtrStripe::class, 'success'])->name('success');
Route::get('cancel', [CtrStripe::class, 'cancel'])->name('cancel');

// Routes pour les authentifications sociales
Route::get('auth/google', [CtrSocialite::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [CtrSocialite::class, 'GoogleCallback']);
Route::get('auth/facebook', [CtrSocialite::class, 'redirectToFacebook']);
Route::get('auth/facebook/callback', [CtrSocialite::class, 'FacebookCallback']);
