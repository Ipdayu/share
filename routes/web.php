<?php

use Illuminate\Support\Facades\Route;
use App\Models\Link;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    $links = Link::activeOrdered()->get();

    // Load Settings
    $settingsPath = storage_path('app/settings.json');
    $settings = file_exists($settingsPath) ? json_decode(file_get_contents($settingsPath), true) : [
        'title' => 'SMK Budi Utomo Way Jepara',
        'bio' => 'Pusat tautan resmi SMK Budi Utomo'
    ];

    return view('public', compact('links', 'settings'));
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.links.index');
        })->name('dashboard');

        Route::post('/upload-logo', [LinkController::class, 'uploadLogo'])->name('upload.logo');
        Route::post('/upload-bg', [LinkController::class, 'uploadBackground'])->name('upload.bg');
        Route::post('/delete-bg', [LinkController::class, 'deleteBackground'])->name('delete.bg');

        Route::post('/upload-music', [LinkController::class, 'uploadMusic'])->name('upload.music');
        Route::post('/delete-music', [LinkController::class, 'deleteMusic'])->name('delete.music');

        Route::post('/upload-gallery', [LinkController::class, 'uploadGallery'])->name('upload.gallery');
        Route::post('/delete-gallery/{slot}', [LinkController::class, 'deleteGallery'])->name('delete.gallery');

        Route::post('/settings', [LinkController::class, 'updateSettings'])->name('settings.update');

        Route::resource('links', LinkController::class)->except(['show']);
    });
});
