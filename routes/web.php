<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Livewire\NotepadPage;
use App\Livewire\SettingsPage;
use App\Livewire\DashboardSettingsPage;

// Redirect halaman utama '/' langsung ke login
Route::redirect('/', '/login');

// Route untuk aplikasi Notepad (harus login)
Route::middleware('auth')->group(function () {
    Route::get('/notepad', NotepadPage::class)->name('notepad');
    Route::get('/settings', SettingsPage::class)->name('settings');
    Route::get('/dashboard-settings', DashboardSettingsPage::class)->name('dashboard-settings');
});

// ---------------------------------------------------------
// Routes Authentication
// ---------------------------------------------------------
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
