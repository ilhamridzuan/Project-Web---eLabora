<?php

namespace App\Http\Controllers;

use App\Services\ExpressApiService;
use Illuminate\Http\Request;

class PemeriksaanController extends Controller
{
    public function index(Request $request, ExpressApiService $apiService)
    {
        $q = $request->query('q');
        $statusHasil = $request->query('status_hasil');
        $page = (int) $request->query('page', 1);

        $meta = [
            'page' => $page,
            'limit' => 20,
            'hasNext' => false,
            'hasPrev' => $page > 1,
        ];

        $exams = [];

        $response = $apiService->examsList([
            'q' => $q,
            'status_hasil' => $statusHasil,
            'page' => $page,
            'limit' => 20,
        ]);

        if ($response->successful()) {
            $json = $response->json();
            $exams = $json['data'] ?? [];
            $meta = $json['meta'] ?? $meta;
        } else {
            // biar tidak error blank
            $err = $response->json('message') ?? 'Gagal mengambil data pemeriksaan';
            return redirect()->back()->with('error', $err);
        }

        return view('pages.admin.pemeriksaan', [
            'exams' => $exams,
            'meta' => $meta,
            'q' => $q,
            'statusHasil' => $statusHasil,
        ]);
    }

    /**
     * CREATE pemeriksaan -> POST /exams
     * Blade: action="{{ url('/petugas/pemeriksaan') }}"
     */
    public function store(Request $request, ExpressApiService $apiService)
    {
        $payload = $request->only([
            'pendaftaran_id',
            'kategori_id',
            'dokter_id',
            'tgl_pemeriksaan',
            'status_validasi',
            'status_hasil',
            'catatan',
        ]);

        // validasi minimal (tanpa mengubah isi form kamu)
        $request->validate([
            'pendaftaran_id' => ['required'],
            'kategori_id' => ['required'],
        ]);

        $res = $apiService->createExam($payload);

        if ($res->successful()) {
            return redirect()->back()->with('success', 'Pemeriksaan berhasil dibuat.');
        }

        $msg = $res->json('message') ?? 'Gagal membuat pemeriksaan.';
        return redirect()->back()->with('error', $msg)->withInput();
    }

    /**
     * UPDATE pemeriksaan -> PATCH /exams/:id
     * Blade: :action="`/petugas/pemeriksaan/${selectedExam.pemeriksaan_id}`"
     */
    public function update(Request $request, ExpressApiService $apiService, int $id)
    {
        // backend Express whitelist field patch (yang lain akan diabaikan) :contentReference[oaicite:4]{index=4}
        $patch = $request->only([
            'dokter_id',
            'status_validasi',
            'status_hasil',
            'catatan',
            'tgl_pemeriksaan',
        ]);

        $res = $apiService->patchExam($id, $patch);

        if ($res->successful()) {
            return redirect()->back()->with('success', 'Pemeriksaan berhasil diperbarui.');
        }

        $msg = $res->json('message') ?? 'Gagal memperbarui pemeriksaan.';
        return redirect()->back()->with('error', $msg)->withInput();
    }

    /**
     * UPLOAD file -> POST /exams/:id/files (field: file)
     * Blade: :action="`/petugas/pemeriksaan/${selectedExam.pemeriksaan_id}/file`"
     */
    public function uploadFile(Request $request, ExpressApiService $apiService, int $id)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png'],
        ]);

        $file = $request->file('file');

        $res = $apiService->uploadExamFile($id, $file);

        if ($res->successful()) {
            return redirect()->back()->with('success', 'File pemeriksaan berhasil diupload.');
        }

        $msg = $res->json('message') ?? 'Gagal upload file pemeriksaan.';
        return redirect()->back()->with('error', $msg);
    }
}
