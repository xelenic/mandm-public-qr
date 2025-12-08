<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminGiftController;
use App\Http\Controllers\Admin\AdminQRCodeController;
use App\Http\Controllers\Admin\AdminScanController;
use App\Http\Controllers\QRScanController;

Route::get('/', function () {
    return view('welcome');
});

// Public QR Code Scanning Routes
Route::get('/qr/{code}', [QRScanController::class, 'show'])->name('qr.scan');
Route::post('/qr/{code}', [QRScanController::class, 'submit'])->name('qr.submit');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Authentication Routes
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', \App\Http\Controllers\Admin\AdminUserController::class);

        // Gift Management
        Route::resource('gifts', AdminGiftController::class);

        // QR Code Management
        Route::resource('qrcodes', AdminQRCodeController::class);
        Route::get('qrcodes/{qrcode}/download', [AdminQRCodeController::class, 'download'])->name('qrcodes.download');
        Route::get('qrcodes-print', [AdminQRCodeController::class, 'print'])->name('qrcodes.print');

        // Customer Scans Management
        Route::resource('scans', AdminScanController::class)->except(['create', 'store']);
        Route::post('scans/{scan}/update-status', [AdminScanController::class, 'updateStatus'])->name('scans.updateStatus');
        Route::get('scans-export', [AdminScanController::class, 'export'])->name('scans.export');
    });
});
