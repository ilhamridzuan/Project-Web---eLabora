<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.app');
});
Route::get('/dashboard', function () {
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