<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ExpressApiService;

class PasienDashboardController extends Controller
{
    public function index(ExpressApiService $api)
    {
        $queues = [];
        $current = null;

        $res = $api->queueToday();
        if ($res->successful()) {
            $json = $res->json();

            // Umumnya format: { tanggal, data: [...] }
            $queues = data_get($json, 'data');
            if (!is_array($queues)) {
                $queues = is_array($json) ? $json : [];
            }

            // ambil yang sedang dilayani/proses dulu
            $current = collect($queues)->first(function ($item) {
                $st = strtoupper((string) data_get($item, 'status', ''));
                return in_array($st, ['DILAYANI', 'PROSES'], true);
            }) ?: ($queues[0] ?? null);
        }

        return view('pages.pasien.dashboard', [
            'queues' => $queues,
            'current' => $current,
        ]);
    }
}