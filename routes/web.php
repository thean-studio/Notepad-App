<?php

use App\Livewire\NotepadPage;
use Illuminate\Support\Facades\Route;

// Welcome route
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Login route
Route::get('/login', function () {
    return view('welcome');
})->name('login');

// Notepad route
Route::get('/notepad', NotepadPage::class)->name('notepad');
