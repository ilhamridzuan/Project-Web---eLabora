<?php

namespace App\Http\Controllers;

use App\Services\ExpressApiService;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request, ExpressApiService $api)
    {
        $kategori = strtolower((string) $request->query('kategori', 'semua'));
        $q = trim((string) $request->query('q', ''));

        $pasienId = (int) session('pasien_id');

        if ($pasienId <= 0 && session()->has('api_token')) {
            $me = $api->authMe();

            if ($me->successful()) {
                $profil = $me->json('profil') ?? [];
                $pasienId = (int) ($profil['id'] ?? 0);

                if ($pasienId > 0) {
                    session(['pasien_id' => $pasienId]);
                }
            }
        }

        if ($pasienId <= 0) {
            return view('pages.pasien.riwayat', [
                'items' => [],
                'kategori' => $kategori,
                'q' => $q,
                'errorMessage' => 'Session pasien_id tidak ditemukan. Pastikan login pasien menyimpan pasien_id.',
            ]);
        }

        // Call Express: GET /exams/patients/:pasienId
        $res = $api->examsByPatient($pasienId);

        if (!$res->successful()) {
            return view('pages.pasien.riwayat', [
                'items' => [],
                'kategori' => $kategori,
                'q' => $q,
                'errorMessage' => $res->json('message') ?? 'Gagal mengambil riwayat dari server.',
            ]);
        }

        $items = $res->json('data') ?? [];

        if ($kategori !== 'semua') {
            $items = array_values(array_filter($items, function ($it) use ($kategori) {
                return strtolower((string) ($it['kategori_nama'] ?? '')) === $kategori;
            }));
        }

        if ($q !== '') {
            $items = array_values(array_filter($items, function ($it) use ($q) {
                $noLab = (string) ($it['no_lab'] ?? '');
                return str_contains($noLab, $q);
            }));
        }

        return view('pages.pasien.riwayat', [
            'items' => $items,
            'kategori' => $kategori,
            'q' => $q,
            'errorMessage' => null,
        ]);
    }
}
