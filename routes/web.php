<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // الصلاحيات المشتركة بين الأدمن والصيدلي
    Route::middleware(['role:admin,pharmacist'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('categories', CategoryController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('medicines', MedicineController::class);

        // مسارات المبيعات وشاشة الـ POS
        Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
        Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
        Route::get('/sales/invoice/{id}', [SaleController::class, 'invoice'])->name('sales.invoice');

        // تم نقل مسار الـ API هنا لضمان عمل البحث الفوري والباركود بسلاسة تامة لأي كاشير/صيدلي مسجل دخول
        Route::get('/api/medicines/search', [MedicineController::class, 'searchApi']);
    });

    // الصلاحيات الخاصة بالمدير (Admin) فقط
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        
        Route::get('/settings', [SettingController::class, 'edit'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    });

});