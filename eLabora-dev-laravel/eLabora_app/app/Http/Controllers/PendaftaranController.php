<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ExpressApiService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index(ExpressApiService $api)
    {
        $profileResp = $api->authMe();
        $profile = $profileResp->ok() ? $profileResp->json() : null;

        return view('pages.pasien.pendaftaran', [
            'profile' => $profile,
        ]);
    }

    public function store(Request $request, ExpressApiService $api)
    {
        $validated = $request->validate([
            'tanggal_antrian' => ['required', 'date'],
            'jadwal_pemeriksaan_at' => ['required'],
            'surat_rujukan' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10000'],
        ]);

        // hidden jadwal formatnya: YYYY-MM-DDTHH:mm
        try {
            $jadwal = Carbon::createFromFormat('Y-m-d\TH:i', $validated['jadwal_pemeriksaan_at'])
                ->format('Y-m-d H:i:s');
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->withErrors(['jadwal_pemeriksaan_at' => 'Jadwal pemeriksaan tidak valid. Silakan pilih waktu pemeriksaan.']);
        }

        $payload = [
            'tanggal_antrian' => $validated['tanggal_antrian'],
            'jadwal_pemeriksaan_at' => $jadwal,
        ];

        $resp = $api->registrationCreate($payload, $request->file('surat_rujukan'));

        if ($resp->successful()) {
            $data = $resp->json();

            return redirect()
                ->route('pasien.pendaftaran.index')
                ->with('success', 'Pendaftaran berhasil. No Antrian: ' . ($data['no_antrian'] ?? '-') . ', No Lab: ' . ($data['no_lab'] ?? '-'));
        }

        $msg = $resp->json('message') ?? ('Gagal mendaftar (HTTP ' . $resp->status() . ')');
        return back()->withInput()->with('error', $msg);
    }
}
