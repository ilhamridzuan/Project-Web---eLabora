<?php

namespace App\Http\Controllers;

use App\Services\ExpressApiService;
use Illuminate\View\View;

class HasilPemeriksaanController extends Controller
{
    protected ExpressApiService $api;

    public function __construct(ExpressApiService $api)
    {
        $this->api = $api;
    }

    // LIST HASIL PEMERIKSAAN
    public function index(): View
    {
        $profileResp = $this->api->authMe();
        $pasienId = $profileResp->json('profil.id') ?? null;

        if (!$pasienId) {
            abort(401, 'Pasien belum login');
        }

        $items = $this->api->listByPatient($pasienId);

        return view('pages.pasien.hasilPemeriksaan', compact('items'));
    }

    public function show($id): View
    {
        $data = $this->api->detail($id);

        return view('pages.pasien.detailHasilPemeriksaan', compact('data'));
    }
}
