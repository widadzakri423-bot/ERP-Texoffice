<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\MouvementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/', function () {
    return redirect()->route('dashboard');
});
// Auth (publique)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
// Utilisateurs (Admin seulement)
Route::middleware('role:administrateur')->group(function () {
    Route::resource('users', UserController::class);
    Route::get('/activity-log', [UserController::class, 'activityLog'])->name('activity.log');
});
// Routes protégées
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    

    Route::resource('clients', ClientController::class);
    Route::resource('machines', MachineController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('devis', DevisController::class);
    Route::get('/devis/{devi}/duplicate', [DevisController::class, 'duplicate'])->name('devis.duplicate');
    Route::get('/devis/{devi}/pdf', [DevisController::class, 'exportPDF'])->name('devis.pdf');
    Route::patch('/devis/{devi}/statut', [DevisController::class, 'changeStatut'])->name('devis.statut');

    Route::get('/mouvements', [MouvementController::class, 'index'])->name('mouvements.index');
    Route::get('/mouvements/create', [MouvementController::class, 'create'])->name('mouvements.create');
    Route::post('/mouvements', [MouvementController::class, 'store'])->name('mouvements.store');
    Route::get('/mouvements/{mouvement}', [MouvementController::class, 'show'])->name('mouvements.show');
    Route::delete('/mouvements/{mouvement}', [MouvementController::class, 'destroy'])->name('mouvements.destroy');

    Route::resource('interventions', InterventionController::class);
});