<?php

use App\Models\Pasien;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardPetugasController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AntrianPasienController;
use App\Http\Controllers\DashboardDokterController;
use App\Http\Controllers\PasienController;  

Route::get('/', function () {
    return redirect()->route('login');
});

// AUTH
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// PASIEN (wajib login + role pasien)
Route::middleware(['requireAuth', 'requireRole:PASIEN'])->group(function () {
    Route::get('/dashboard-pasien', function () {
        return view('pages.pasien.dashboard');
    })->name('dashboard.pasien');

    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pasien.pendaftaran.index');
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pasien.pendaftaran.store');

    Route::get('/antrian-pasien', [AntrianPasienController::class, 'index'])->name('antrian.pasien');

    Route::get('/hasil-pemeriksaan', function () {
        return view('pages.pasien.hasilPemeriksaan');
    })->name('hasil.pemeriksaan');

    Route::get('/riwayat', function () {
        return view('pages.pasien.riwayat');
    })->name('riwayat');
});

// PETUGAS
Route::middleware(['requireAuth', 'requireRole:PETUGAS'])->group(function () {
    Route::get('/dashboard-petugas', [DashboardPetugasController::class, 'index'])
        ->name('dashboard.petugas');
    Route::get('/antrian', [AntrianController::class, 'index'])->name('antrian.petugas');
    Route::post('/antrian/{id}/call', [AntrianController::class, 'call'])->name('antrian.call');
    Route::post('/antrian/{id}/next', [AntrianController::class, 'next'])->name('antrian.next');
    Route::post('/antrian/{id}/cancel', [AntrianController::class, 'cancel'])->name('antrian.cancel');
    Route::get('/pemeriksaan', [PemeriksaanController::class, 'index'])
        ->name('pemeriksaan.petugas');
});
// DOKTER
Route::middleware(['requireAuth', 'requireRole:DOKTER'])->group(function () {
    Route::get('/dashboard-dokter',  [DashboardDokterController::class, 'index'] )->name('dashboard.dokter');
    Route::get('/pasien-dokter', [PasienController::class, 'index'])->name('pasien.dokter');
});
