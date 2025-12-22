<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ExpressApiService;
use Illuminate\Http\Request;

class PemeriksaanController extends Controller
{
    public function index(Request $request, ExpressApiService $apiService)
    {
        $q = $request->query('q');
        $statusHasil = $request->query('status_hasil');
        $page = (int) $request->query('page', 1);

        $exams = [];
        $meta = [
            'page' => $page,
            'hasNext' => false,
            'hasPrev' => false,
        ];

        $response = $apiService->examsList([
            'q' => $q,
            'status_hasil' => $statusHasil,
            'page' => $page,
        ]);

        if ($response->successful()) {
            $json = $response->json();
            $exams = $json['data'] ?? [];
            $meta = $json['meta'] ?? $meta;
        }

        return view('pages.admin.pemeriksaan', [
            'exams' => $exams,
            'meta' => $meta,
            'q' => $q,
            'statusHasil' => $statusHasil,
        ]);
    }
}
