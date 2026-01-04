@extends('layouts.app', ['sidebar' => 'dokter'])

@section('title', 'Hasil Pemeriksaan Pasien')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-slate-800">Hasil Pemeriksaan</h2>
            <p class="mt-1 text-sm text-slate-500">
                @if($pasienName)
                Pasien: <span class="font-semibold text-slate-700">{{ $pasienName }}</span>
                @else
                ID Pasien: <span class="font-semibold text-slate-700">{{ $pasienId }}</span>
                @endif
            </p>
        </div>

        <a
            href="{{ route('pasien.dokter') }}"
            class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
            ← Kembali
        </a>
    </div>

    {{-- ERROR --}}
    @if($errorMessage)
    <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 text-sm">
        {{ $errorMessage }}
    </div>
    @endif

    {{-- TABLE --}}
    <div class="rounded-xl bg-white shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-center">
                        <th class="px-4 py-3 w-16">No</th>
                        <th class="px-4 py-3">ID Pemeriksaan</th>
                        <th class="px-4 py-3">ID Pendaftaran</th>
                        <th class="px-4 py-3 text-left">Kategori</th>
                        <th class="px-4 py-3">Tgl Pemeriksaan</th>
                        <th class="px-4 py-3 text-left">Catatan</th>
                        <th class="px-4 py-3 w-[160px]">Hasil</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($exams as $exam)
                    @php
                    $examId = $exam['pemeriksaan_id'] ?? $exam['id'] ?? '-';
                    $fileUrl = $exam['file_url'] ?? $exam['file'] ?? null;
                    @endphp

                    <tr class="hover:bg-slate-50/60">
                        <td class="px-4 py-3 text-center text-slate-600">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-3 text-center tabular-nums">
                            {{ $examId }}
                        </td>

                        <td class="px-4 py-3 text-center tabular-nums">
                            {{ $exam['pendaftaran_id'] ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-left font-medium text-slate-800">
                            {{ $exam['kategori_nama'] ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-center text-slate-700">
                            {{ $exam['tgl_pemeriksaan'] ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-left text-slate-700">
                            <div class="line-clamp-2">
                                {{ $exam['catatan'] ?? '-' }}
                            </div>
                        </td>

                        <td class="px-4 py-3 text-center">
                            @php
                            $downloadUrl = $exam['download_url'] ?? null;
                            @endphp

                            @if($downloadUrl)
                            <a href="{{ $downloadUrl }}" target="_blank"
                                class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-emerald-700 transition">
                                Download
                            </a>
                            @else
                            <span class="text-xs text-slate-400">Tidak ada file</span>
                            @endif

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-10 text-center">
                            <p class="text-sm font-semibold text-slate-700">
                                Belum ada hasil pemeriksaan
                            </p>
                            <p class="text-xs text-slate-500 mt-1">
                                Hanya pemeriksaan dengan status HASIL_TERSEDIA yang ditampilkan.
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection