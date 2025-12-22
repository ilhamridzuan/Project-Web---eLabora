@extends('layouts.app', ['sidebar' => 'admin'])

@section('title', 'Manajemen Pemeriksaan')

@section('content')

<div
    x-data="{
        openCreate: false,
        openDetail: false,
        openUpload: false,
        selectedExam: null
    }"
    class="space-y-6"
>

    {{-- ================= HEADER ================= --}}
    <div>
        <h2 class="text-2xl font-semibold text-slate-800">Manajemen Pemeriksaan</h2>
        <p class="text-sm text-slate-500 mt-1">
            Daftar seluruh pemeriksaan terbaru
        </p>
    </div>

    {{-- ================= FLASH MESSAGE ================= --}}
    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 text-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- ================= ACTION BAR ================= --}}
    <div class="flex justify-end">
        <button
            @click="openCreate = true"
            class="rounded-lg bg-indigo-600 text-white px-4 py-2 text-sm font-semibold hover:bg-indigo-700">
            + Buat Pemeriksaan
        </button>
    </div>

    {{-- ================= TABLE ================= --}}
    <div class="rounded-xl bg-white shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left">
                        <th class="px-4 py-3 w-16">No</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Pasien</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Status Hasil</th>
                        <th class="px-4 py-3 w-40">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($exams as $i => $exam)
                        @php
                            $status = strtoupper($exam['status_hasil'] ?? '-');
                            $badge = 'bg-slate-100 text-slate-700 border-slate-200';

                            if ($status === 'MENUNGGU') $badge = 'bg-amber-50 text-amber-700 border-amber-200';
                            if ($status === 'PROSES')   $badge = 'bg-indigo-50 text-indigo-700 border-indigo-200';
                            if ($status === 'SELESAI')  $badge = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                        @endphp

                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-3">
                                {{ ($meta['page'] - 1) * 20 + $i + 1 }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $exam['tgl_pemeriksaan'] ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="font-medium text-slate-800">
                                    {{ $exam['pasien_nama'] ?? '-' }}
                                </div>
                                <div class="text-xs text-slate-500">
                                    {{ $exam['nik'] ?? '-' }}
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                {{ $exam['kategori_nama'] ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg border text-xs font-semibold {{ $badge }}">
                                    {{ $status }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <button
                                        @click="openDetail = true; selectedExam = {{ json_encode($exam) }}"
                                        class="px-2.5 py-1.5 rounded-lg text-xs border hover:bg-slate-50">
                                        Detail / Edit
                                    </button>

                                    <button
                                        @click="openUpload = true; selectedExam = {{ json_encode($exam) }}"
                                        class="px-2.5 py-1.5 rounded-lg text-xs border hover:bg-slate-50">
                                        Upload
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-slate-500">
                                Tidak ada data pemeriksaan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ================= PAGINATION ================= --}}
        <div class="flex items-center justify-between px-4 py-3 border-t border-slate-200">
            <span class="text-sm text-slate-500">
                Halaman {{ $meta['page'] }}
            </span>

            <div class="flex gap-2">
                @if($meta['hasPrev'])
                    <a href="{{ request()->fullUrlWithQuery(['page' => $meta['page'] - 1]) }}"
                       class="px-3 py-1.5 rounded-lg border hover:bg-slate-50 text-sm">
                        ← Prev
                    </a>
                @else
                    <span class="px-3 py-1.5 rounded-lg border text-slate-400 text-sm">
                        ← Prev
                    </span>
                @endif

                @if($meta['hasNext'])
                    <a href="{{ request()->fullUrlWithQuery(['page' => $meta['page'] + 1]) }}"
                       class="px-3 py-1.5 rounded-lg border hover:bg-slate-50 text-sm">
                        Next →
                    </a>
                @else
                    <span class="px-3 py-1.5 rounded-lg border text-slate-400 text-sm">
                        Next →
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- ================= MODAL CREATE ================= --}}
    <div x-show="openCreate" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Buat Pemeriksaan</h3>

            <form method="POST" action="{{ url('/petugas/pemeriksaan') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="text-sm font-medium">Pendaftaran ID</label>
                    <input name="pendaftaran_id" required
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm">
                </div>

                <div>
                    <label class="text-sm font-medium">Kategori</label>
                    <select name="kategori_id"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm">
                        @foreach($kategoriList ?? [] as $kat)
                            <option value="{{ $kat['id'] }}">{{ $kat['nama'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">Catatan</label>
                    <textarea name="catatan" rows="3"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm"></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="openCreate=false"
                        class="px-4 py-2 text-sm border rounded-lg">
                        Batal
                    </button>
                    <button class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= MODAL DETAIL / EDIT ================= --}}
    <div x-show="openDetail" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Detail / Edit Pemeriksaan</h3>

            <form
                method="POST"
                :action="`/petugas/pemeriksaan/${selectedExam.pemeriksaan_id}`"
                class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label class="text-sm font-medium">Status Hasil</label>
                    <select name="status_hasil"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm">
                        <option value="MENUNGGU">MENUNGGU</option>
                        <option value="PROSES">PROSES</option>
                        <option value="SELESAI">SELESAI</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">Catatan</label>
                    <textarea
                        name="catatan"
                        rows="3"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm"
                        x-text="selectedExam?.catatan ?? ''"></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="openDetail=false"
                        class="px-4 py-2 text-sm border rounded-lg">
                        Tutup
                    </button>
                    <button class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= MODAL UPLOAD FILE ================= --}}
    <div x-show="openUpload" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div class="bg-white w-full max-w-md rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Upload File Pemeriksaan</h3>

            <form
                method="POST"
                enctype="multipart/form-data"
                :action="`/petugas/pemeriksaan/${selectedExam.pemeriksaan_id}/file`">
                @csrf

                <input type="file" name="file" class="mb-4">

                <div class="flex justify-end gap-2">
                    <button type="button" @click="openUpload=false"
                        class="px-4 py-2 text-sm border rounded-lg">
                        Batal
                    </button>
                    <button class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
