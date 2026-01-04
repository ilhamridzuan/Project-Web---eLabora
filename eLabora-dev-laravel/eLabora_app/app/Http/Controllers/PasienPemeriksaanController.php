<?php

namespace App\Http\Controllers;

use App\Services\ExpressApiService;
use Illuminate\Http\Request;

class PasienPemeriksaanController extends Controller
{
    public function index(int $id, Request $request, ExpressApiService $api)
    {
        // ambil info pasien (opsional, untuk judul halaman)
        $pasienName = null;
        try {
            $p = $api->pasienDetail($id);
            if ($p->successful()) {
                $pasienName = data_get($p->json(), 'data.nama')
                    ?? data_get($p->json(), 'nama')
                    ?? data_get($p->json(), 'data.name')
                    ?? data_get($p->json(), 'name');
            }
        } catch (\Throwable $e) {
            // ignore (tetap tampil list pemeriksaan)
        }

        $res = $api->examsByPatient($id);

        if (!$res->successful()) {
            $msg = $res->json('message') ?? 'Gagal mengambil hasil pemeriksaan pasien.';
            return view('pages.admin.pasien_pemeriksaan', [
                'pasienId' => $id,
                'pasienName' => $pasienName,
                'exams' => [],
                'errorMessage' => $msg,
            ]);
        }

        $json = $res->json();
        $exams = data_get($json, 'data');
        if (!is_array($exams)) $exams = [];

        return view('pages.admin.pasien_pemeriksaan', [
            'pasienId' => $id,
            'pasienName' => $pasienName,
            'exams' => $exams,
            'errorMessage' => null,
        ]);
    }

    public function updateExam(int $examId, Request $request, ExpressApiService $api)
    {
        $validated = $request->validate([
            'status_validasi' => ['required', 'string', 'in:DRAFT,TERVALIDASI'],
            'status_hasil' => ['required', 'string', 'in:MENUNGGU_HASIL,HASIL_TERSEDIA,TIDAK_TERSEDIA'],
            'catatan' => ['nullable', 'string'],
        ]);

        $res = $api->patchExam($examId, [
            'status_validasi' => $validated['status_validasi'],
            'status_hasil' => $validated['status_hasil'],
            'catatan' => $validated['catatan'] ?? null,
        ]);

        if (!$res->successful()) {
            $msg = $res->json('message') ?? 'Gagal memperbarui pemeriksaan.';
            return back()->with('error', $msg);
        }

        return back()->with('success', 'Pemeriksaan berhasil diperbarui.');
    }

    public function uploadExamFile(int $examId, Request $request, ExpressApiService $api)
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $res = $api->uploadExamFile($examId, $validated['file']);

        if (!$res->successful()) {
            $msg = $res->json('message') ?? 'Gagal upload file pemeriksaan.';
            return back()->with('error', $msg);
        }

        return back()->with('success', 'File pemeriksaan berhasil diupload.');
    }
}
