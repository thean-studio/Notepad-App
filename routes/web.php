<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Livewire\NotepadPage;
use App\Livewire\SettingsPage;

// Opsional: Redirect halaman utama '/' langsung ke notepad
Route::redirect('/', '/notepad');

// Route untuk aplikasi Notepad
Route::get('/notepad', NotepadPage::class)->name('notepad');
Route::get('/settings', SettingsPage::class)->name('settings');

// ---------------------------------------------------------
// Routes Authentication
// ---------------------------------------------------------
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
