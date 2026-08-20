<?php

use App\Http\Controllers\PdfController;
use App\Http\Controllers\VerificationController;
use App\Livewire\LabRequests;
use App\Livewire\Patients;
use App\Livewire\Users;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

// Halaman Publik Verifikasi QR Code (Tanpa Auth)
Route::get('/verify/{qr_token}', [VerificationController::class, 'show'])->name('verify.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // Manajemen Pengguna & Role
    Route::get('/users', Users\Index::class)->name('users.index');

    // Manajemen Pasien
    Route::get('/patients', Patients\Index::class)->name('patients.index');

    // Pemeriksaan Lab & Hasil
    Route::get('/lab-requests', LabRequests\Index::class)->name('lab-requests.index');
    Route::get('/lab-requests/create', LabRequests\Create::class)->name('lab-requests.create');
    Route::get('/lab-requests/{labRequest}', LabRequests\Show::class)->name('lab-requests.show');

    // PDF Generation
    Route::get('/lab-requests/{labRequest}/pdf', [PdfController::class, 'generateLabReport'])->name('lab-requests.pdf');
});

require __DIR__.'/settings.php';
