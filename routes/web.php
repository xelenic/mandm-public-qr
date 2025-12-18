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
Route::get('/qr/{code}/how-to-join', [QRScanController::class, 'howToJoin'])->name('qr.how-to-join');

// Public Campaign Info Pages (linked from the QR landing menu)
Route::view('/campaign-details', 'qr.campaign-details')->name('campaign.details');
Route::view('/terms-and-conditions', 'qr.terms-and-conditions')->name('campaign.terms');
Route::view('/winners-gallery', 'qr.winners-gallery')->name('campaign.winners');

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
        Route::delete('qrcodes/bulk-delete', [AdminQRCodeController::class, 'bulkDelete'])->name('qrcodes.bulkDelete');
        Route::delete('qrcodes/truncate', [AdminQRCodeController::class, 'truncate'])->name('qrcodes.truncate');
        Route::get('qrcodes-print', [AdminQRCodeController::class, 'print'])->name('qrcodes.print');
        Route::get('qrcodes/{qrcode}/download', [AdminQRCodeController::class, 'download'])->name('qrcodes.download');
        Route::get('qrcodes/{qrcode}/download-svg', [AdminQRCodeController::class, 'downloadSvg'])->name('qrcodes.downloadSvg');
        Route::resource('qrcodes', AdminQRCodeController::class);

        // Customer Scans Management
        Route::resource('scans', AdminScanController::class)->except(['create', 'store']);
        Route::post('scans/{scan}/update-status', [AdminScanController::class, 'updateStatus'])->name('scans.updateStatus');
        Route::get('scans-export', [AdminScanController::class, 'export'])->name('scans.export');
    });
});
