<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\UserAssetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.assets');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User routes
Route::middleware(['auth'])->prefix('my')->name('user.')->group(function () {
    Route::get('/assets', [UserAssetController::class, 'index'])->name('assets');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/assignments', [AdminController::class, 'assignments'])->name('assignments');
    
    // Asset management
    Route::resource('assets', AssetController::class);
    Route::post('/assets/{asset}/assign', [AssetController::class, 'assign'])->name('assets.assign');
    Route::post('/assignments/{assignment}/return', [AssetController::class, 'returnAsset'])->name('assignments.return');
});

require __DIR__.'/auth.php';
