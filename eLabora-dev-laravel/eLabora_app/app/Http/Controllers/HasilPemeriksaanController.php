<?php

namespace App\Http\Controllers;

use App\Services\ExpressApiService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HasilPemeriksaanController extends Controller
{
    protected ExpressApiService $api;

    public function __construct(ExpressApiService $api)
    {
        $this->api = $api;
    }

    // LIST HASIL PEMERIKSAAN
    public function index(Request $request): View
    {
        $profileResp = $this->api->authMe();
        $pasienId = $profileResp->json('profil.id') ?? null;

        if (!$pasienId) {
            abort(401, 'Pasien belum login');
        }

        // ambil query
        $kategori = strtolower($request->get('kategori', 'semua'));
        $q = trim($request->get('q', ''));

        // ambil data dari API
        $items = $this->api->listByPatient($pasienId);

        // FILTER KATEGORI
        if ($kategori !== 'semua') {
            $items = array_filter($items, function ($item) use ($kategori) {
                return strtolower($item['kategori_nama'] ?? '') === $kategori;
            });
        }

        // FILTER NOMOR LAB
        if ($q !== '') {
            $items = array_filter($items, function ($item) use ($q) {
                return str_contains(
                    strtolower($item['no_lab'] ?? ''),
                    strtolower($q)
                );
            });
        }

        return view('pages.pasien.hasilPemeriksaan', [
            'items' => array_values($items),
            'kategori' => $kategori,
            'q' => $q,
        ]);
    }

    public function show($id): View
    {
        $data = $this->api->detail($id);

        return view('pages.pasien.detailHasilPemeriksaan', compact('data'));
    }
}
