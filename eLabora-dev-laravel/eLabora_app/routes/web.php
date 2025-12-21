<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    // arahkan ke login (atau landing page kalau kamu punya)
    return redirect()->route('login');
});
Route::get('/dashboard-pasien', function () {
    return view('pages.pasien.dashboard');
});
Route::get('/dashboard-petugas', function () {
    return view('pages.admin.dashboard');
});
Route::get('/pendaftaran', function () {
    return view('pages.pasien.pendaftaran');
});
Route::get('/antrian', function () {
    return view('pages.pasien.antrian'); 
});
Route::get('/hasilPemeriksaan', function () {
    return view('pages.pasien.hasilPemeriksaan');
});
Route::get('/riwayat', function () {
    return view('pages.pasien.riwayat');
});
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('requireApiLogin')->group(function () {

    Route::get('/dashboard-pasien', function () {
        return view('pages.pasien.dashboard');
    })->name('dashboard.pasien');

    Route::get('/dashboard-petugas', function () {
        return view('pages.admin.dashboard');
    })->name('dashboard.petugas');

    Route::get('/dashboard-dokter', function () {
        return view('pages.dokter.dashboard');
    })->name('dashboard.dokter');

    Route::get('/pendaftaran', function () {
        return view('pages.pasien.pendaftaran');
    })->name('pendaftaran');

    Route::get('/antrian', function () {
        return view('pages.pasien.antrian');
    })->name('antrian');
});