<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ServiceAdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ChatController;
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
    Route::get('/dashboard', [ProfileController::class, 'index'])->name('dashboard');
    Route::get('/profile/services', [ProfileController::class, 'services'])->name('profile.services');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/service-disconnect/{id}', [ServiceController::class, 'disconnect'])->name('service.disconnect');
});
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/', [HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::post('/invoice/{id}/pay', [InvoiceController::class, 'pay'])->name('invoice.pay');
    Route::delete('/invoice/{id}/disconnect', [InvoiceController::class, 'disconnect'])->name('invoice.disconnect');
});
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users/{id}/tariffs', [UserController::class, 'userTariffs'])->name('users.tariffs');
});
Route::middleware(['auth', 'role:3'])->get('/profile/invoices', [ProfileController::class, 'invoices'])->name('profile.invoices');
    Route::middleware(['auth'])->prefix('admin/reports')->name('admin.reports.')->group(function () {
    Route::get('/network', [ReportController::class, 'networkEquipment'])->name('network');
    Route::get('/network/pdf', [ReportController::class, 'networkEquipmentPdf'])->name('network.pdf');
    Route::get('/services', [ReportController::class, 'connectedServices'])->name('services');
    Route::get('/services/pdf', [ReportController::class, 'connectedServicesPdf'])->name('services.pdf');
});
// Для отчёта по оборудованию
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/reports/network/{id}/edit', [ReportController::class, 'editNetwork'])->name('reports.network.edit');
    Route::put('/reports/network/{id}', [ReportController::class, 'updateNetwork'])->name('reports.network.update');
    Route::delete('/reports/network/{mac}', [ReportController::class, 'destroy'])->name('reports.network.destroy');

    // Для подключённых услуг
    Route::get('/reports/service/{id}/edit', [ReportController::class, 'editService'])->name('reports.service.edit');
    Route::put('/reports/service/{id}', [ReportController::class, 'updateService'])->name('reports.service.update');
    Route::delete('/reports/service/{id}', [ReportController::class, 'destroyService'])->name('reports.service.destroy');
});

Route::middleware('auth')->prefix('chat')->group(function () {
    // Для клиентов
    Route::post('/create', [ChatController::class, 'createRequest'])->name('chat.create');
    Route::get('/{request_id}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/{request_id}/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    
    // Для поддержки
    Route::get('/requests', [ChatController::class, 'listRequests'])->name('chat.requests');
});


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/services', [ServiceAdminController::class, 'index'])->name('home');
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
