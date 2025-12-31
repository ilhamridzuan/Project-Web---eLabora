<?php

namespace App\Http\Controllers;

use App\Services\ExpressApiService;
use Illuminate\Http\Request;

class ManajemenPasienController extends Controller
{
    public function index(Request $request, ExpressApiService $api)
    {
        $q = $request->query('q');

        $res = $api->pasien(array_filter([
            'q' => $q,
        ], fn ($v) => $v !== null && $v !== ''));

        if (!$res->successful()) {
            $msg = $res->json('message') ?? 'Gagal mengambil data pasien.';
            return view('pages.admin.pasien', [
                'patients' => [],
                'q' => $q,
                'errorMessage' => $msg,
            ]);
        }

        $json = $res->json();

        /**
         * Support berbagai bentuk response:
         * 1) { data: [...] }
         * 2) { patients: [...] }
         * 3) { rows: [...] }
         * 4) { data: { data: [...] } } (paginasi)
         * 5) [...] (array langsung)
         */
        $patients =
            data_get($json, 'data.data') ??
            data_get($json, 'data') ??
            data_get($json, 'patients') ??
            data_get($json, 'rows');

        // jika response langsung array list pasien
        if ($patients === null && is_array($json)) {
            // kalau ini array list (index 0 ada), ambil langsung
            $patients = array_key_exists(0, $json) ? $json : [];
        }

        // kalau ternyata single object pasien, bungkus jadi array
        if (is_array($patients) && !array_key_exists(0, $patients) && !empty($patients)) {
            $patients = [ $patients ];
        }

        return view('pages.admin.pasien', [
            'patients' => is_array($patients) ? $patients : [],
            'q' => $q,
            'errorMessage' => null,
        ]);
    }
}
