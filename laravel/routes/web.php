<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ServiceAdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;

\Illuminate\Support\Facades\Log::info('Route file loaded');

Route::get('/ping', function() {
    \Log::info('Ping received');
    return response()->json(['status' => 'ok']);
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/client/dashboard', function () {
        return view('dashboards.client');
    })->middleware('role:client');

    Route::get('/operator/dashboard', function () {
        return view('dashboards.operator');
    })->middleware('role:operator');

    Route::get('/admin/dashboard', function () {
        return view('dashboards.admin');
    })->middleware('role:admin');
});
Route::get('/register', [\App\Http\Controllers\AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/internet', [ServiceController::class, 'internet'])->name('internet');
Route::get('/tv', [ServiceController::class, 'tv'])->name('tv');
Route::get('/mobile', [ServiceController::class, 'mobile'])->name('mobile');
Route::get('/services/{id}/connect', [ServiceController::class, 'showConnectForm'])
     ->name('services.connect')
     ->middleware('auth');
Route::post('/services/{id}/subscribe', [ServiceController::class, 'subscribe'])
     ->name('services.subscribe')
     ->middleware('auth');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
Route::middleware(['auth', 'check.role:3'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
});
Route::middleware(['auth', 'role:3'])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');
});
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::middleware(['auth', 'role:3'])->group(function () {
    Route::delete('/service-disconnect/{id}', [ServiceController::class, 'disconnect'])->name('service.disconnect');
});
Route::middleware(['auth', 'role:1'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/services', [ServiceAdminController::class, 'index'])->name('services.index');
    Route::get('/services/create', [ServiceAdminController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceAdminController::class, 'store'])->name('services.store');
    Route::get('/services/{id}/edit', [ServiceAdminController::class, 'edit'])->name('services.edit');
    Route::put('/services/{id}', [ServiceAdminController::class, 'update'])->name('services.update');
    Route::delete('/services/{id}', [ServiceAdminController::class, 'destroy'])->name('services.destroy');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});
require __DIR__.'/auth.php';
