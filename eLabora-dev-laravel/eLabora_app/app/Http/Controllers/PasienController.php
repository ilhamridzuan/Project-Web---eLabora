<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ExpressApiService;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index(Request $request, ExpressApiService $api)
    {
        $patients = [];
        $meta = [];

        $response = $api->pasien([
            'search' => $request->query('search'),
            'page' => $request->query('page', 1),
            'pageSize' => 20,
        ]);

        if ($response->successful()) {
            $payload = $response->json();

            // Selaras dengan response Express API
            $patients = $payload['items'] ?? [];
            $meta = [
                'page' => $payload['page'] ?? 1,
                'pageSize' => $payload['pageSize'] ?? 20,
                'total' => $payload['total'] ?? 0,
            ];
        }
        
        $selectedPatient = null;

        if ($request->filled('pasien')) {
            $detail = $api->pasienDetail((int) $request->query('pasien'));

            if ($detail->successful()) {
                $selectedPatient = $detail->json();
            }
        }

        return view('pages.dokter.pasien', [
            'patients' => $patients,
            'selectedPatient' => $selectedPatient,
            'meta' => $meta,
        ]);
    }
}
