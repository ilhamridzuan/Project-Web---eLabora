<?php

namespace App\Http\Controllers;

use App\Services\ExpressApiService;
use Illuminate\Http\Request;

class PemeriksaanController extends Controller
{
    private function kategoriList(): array
    {
        return [
            ['id' => 1, 'nama' => 'Patologi'],
            ['id' => 2, 'nama' => 'Anatomi'],
            ['id' => 3, 'nama' => 'Mikrobiologi'],
        ];
    }

    public function index(Request $request, ExpressApiService $api)
    {
        $q = $request->query('q');
        $statusHasil = $request->query('status_hasil');

        $page  = (int) $request->query('page', 1);
        $limit = (int) $request->query('limit', 20);

        $res = $api->examsList(array_filter([
            'q' => $q,
            'status_hasil' => $statusHasil,
            'page' => $page,
            'limit' => $limit,
        ], fn($v) => $v !== null && $v !== ''));

        if (!$res->successful()) {
            $msg = $res->json('message') ?? 'Gagal mengambil data pemeriksaan.';
            return view('pages.admin.pemeriksaan', [
                'exams' => [],
                'meta' => ['page' => $page, 'limit' => $limit, 'total' => 0, 'total_pages' => 1],
                'q' => $q,
                'statusHasil' => $statusHasil,
                'kategoriList' => $this->kategoriList(),
                'errorMessage' => $msg,
            ]);
        }

        $json = $res->json();

        return view('pages.admin.pemeriksaan', [
            'exams' => data_get($json, 'data', []),
            'meta' => data_get($json, 'meta', ['page' => $page, 'limit' => $limit]),
            'q' => $q,
            'statusHasil' => $statusHasil,
            'kategoriList' => $this->kategoriList(),
            'errorMessage' => null,
        ]);
    }

    public function store(Request $request, ExpressApiService $api)
    {
        $validated = $request->validate([
            'pendaftaran_id' => ['required', 'integer', 'min:1'],
            'kategori_id' => ['required', 'integer', 'in:1,2,3'],
            'catatan' => ['nullable', 'string'],
        ]);

        $res = $api->createExam($validated);

        if (!$res->successful()) {
            $msg = $res->json('message') ?? 'Gagal membuat pemeriksaan.';
            return back()->withInput()->with('error', $msg);
        }

        return back()->with('success', 'Pemeriksaan berhasil dibuat.');
    }

    public function update(Request $request, ExpressApiService $api, int $id)
    {
        $validated = $request->validate([
            'status_validasi' => ['required', 'string', 'in:DRAFT,TERVALIDASI'],
            'status_hasil' => ['required', 'string', 'in:MENUNGGU_HASIL,HASIL_TERSEDIA,TIDAK_TERSEDIA'],
            'catatan' => ['nullable', 'string'],
        ]);

        $payload = [
            'status_validasi' => $validated['status_validasi'],
            'status_hasil' => $validated['status_hasil'],
            'catatan' => $validated['catatan'] ?? null,
        ];

        $res = $api->patchExam($id, $payload);

        if (!$res->successful()) {
            $msg = $res->json('message') ?? 'Gagal memperbarui pemeriksaan.';
            return back()->with('error', $msg);
        }

        return back()->with('success', 'Pemeriksaan berhasil diperbarui.');
    }


    public function uploadFile(Request $request, ExpressApiService $api, int $id)
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // max 5MB
        ]);

        $res = $api->uploadExamFile($id, $validated['file']);

        if (!$res->successful()) {
            $msg = $res->json('message') ?? 'Gagal upload file pemeriksaan.';
            return back()->with('error', $msg);
        }

        return back()->with('success', 'File pemeriksaan berhasil diupload.');
    }
}
