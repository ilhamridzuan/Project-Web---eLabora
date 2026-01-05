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
        if (!is_array($items)) $items = [];

        /**
         * hanya tampilkan status_hasil = 'HASIL_TERSEDIA'
         */
        $items = array_filter($items, function ($item) {
            $status =
                $item['status_hasil'] ??
                $item['statusHasil'] ??
                null;

            $status = strtoupper(trim((string) $status));
            return $status === 'HASIL_TERSEDIA';
        });

        // FILTER KATEGORI
        if ($kategori !== 'semua') {
            $items = array_filter($items, function ($item) use ($kategori) {
                return strtolower(trim((string)($item['kategori_nama'] ?? ''))) === $kategori;
            });
        }

        // FILTER NOMOR LAB
        if ($q !== '') {
            $qLower = strtolower($q);
            $items = array_filter($items, function ($item) use ($qLower) {
                return str_contains(
                    strtolower((string)($item['no_lab'] ?? '')),
                    $qLower
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
