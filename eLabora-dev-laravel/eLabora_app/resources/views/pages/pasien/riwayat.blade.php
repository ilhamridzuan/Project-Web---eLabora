@extends('layouts.app', ['sidebar' => 'pasien'])

@section('title', 'Riwayat Pemeriksaan')

@section('content')
@php
    $kategoriAktif = request('kategori', 'Semua');

    $dataRiwayat = $dataRiwayat ?? [
        ['kategori'=>'Patologi','judul'=>'Pemeriksaan Patologi','tanggal'=>'Kamis, 05 Juni 2025 • 12.30','noLab'=>'252342123','noOrder'=>'OM7346123','status'=>'Menunggu Hasil'],
        ['kategori'=>'Patologi','judul'=>'Pemeriksaan Patologi','tanggal'=>'Kamis, 05 Juni 2025 • 12.30','noLab'=>'252342124','noOrder'=>'OM7346124','status'=>'Hasil Tersedia'],
        ['kategori'=>'Anatomi','judul'=>'Pemeriksaan Anatomi','tanggal'=>'Kamis, 05 Juni 2025 • 12.30','noLab'=>'252341000','noOrder'=>'OM456000','status'=>'Dibatalkan'],
        ['kategori'=>'Mikrobiologi','judul'=>'Pemeriksaan Mikrobiologi','tanggal'=>'Jumat, 06 Juni 2025 • 08.10','noLab'=>'250010001','noOrder'=>'OM111001','status'=>'Hasil Tersedia'],
        ['kategori'=>'Patologi','judul'=>'Pemeriksaan Patologi','tanggal'=>'Jumat, 06 Juni 2025 • 09.20','noLab'=>'253400112','noOrder'=>'OM658932','status'=>'Menunggu Hasil'],
    ];

    $filtered = $kategoriAktif === 'Semua'
        ? $dataRiwayat
        : array_values(array_filter($dataRiwayat, fn($i) => $i['kategori'] === $kategoriAktif));

    // Warna status dibuat lebih “kalem” dan konsisten
    $statusClass = fn($s) => match($s) {
        'Hasil Tersedia' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'Dibatalkan'     => 'bg-rose-50 text-rose-700 ring-rose-200',
        default          => 'bg-amber-50 text-amber-800 ring-amber-200',
    };

    // Icon dibuat netral (biar tidak tabrakan warna)
    $iconClass = fn($k) => match($k) {
        'Anatomi'      => 'bg-violet-50 text-violet-700 ring-violet-200',
        'Mikrobiologi' => 'bg-sky-50 text-sky-700 ring-sky-200',
        default        => 'bg-orange-50 text-orange-700 ring-orange-200',
    };

    // Chip kategori dibuat soft dan seragam (lebih rapi)
    $kategoriChip = fn($k) => 'bg-gray-50 text-gray-700 ring-gray-200';
@endphp

<div class="max-w-4xl space-y-5">
    {{-- Toolbar --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Riwayat Pemeriksaan</h1>
            <p class="text-sm text-gray-500">Lihat riwayat pemeriksaan berdasarkan kategori.</p>
        </div>

        <form method="GET" class="w-full sm:w-auto">
            <div class="flex items-center justify-end gap-3">
                <label for="filterKat" class="text-sm font-medium text-gray-700">Kategori</label>

                <select
                    id="filterKat"
                    name="kategori"
                    onchange="this.form.submit()"
                    class="w-44 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 shadow-sm
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                >
                    @foreach (['Semua','Patologi','Anatomi','Mikrobiologi'] as $kat)
                        <option value="{{ $kat }}" {{ $kategoriAktif === $kat ? 'selected' : '' }}>
                            {{ $kat }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    {{-- List (1 kolom ke bawah) --}}
    @if (count($filtered) === 0)
        <div class="rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center">
            <p class="text-sm text-gray-600">Tidak ada data untuk kategori yang dipilih.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($filtered as $item)
                <article class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-200 hover:shadow-md transition">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:gap-4">
                        {{-- Icon --}}
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl ring-1 {{ $iconClass($item['kategori']) }}">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M9 3v5l-5 9a4 4 0 0 0 3.5 6h9a4 4 0 0 0 3.5-6l-5-9V3"
                                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9 8h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>

                        {{-- Body --}}
                        <div class="min-w-0 flex-1">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h3 class="truncate text-base font-semibold text-gray-900">
                                        {{ $item['judul'] }}
                                    </h3>
                                    <p class="mt-0.5 text-sm text-gray-600">
                                        {{ $item['tanggal'] }}
                                    </p>
                                </div>

                                {{-- Status (selalu di kanan, rapi) --}}
                                <span class="shrink-0 rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $statusClass($item['status']) }}">
                                    {{ $item['status'] }}
                                </span>
                            </div>

                            {{-- Meta --}}
                            <div class="mt-3 flex flex-wrap items-center gap-x-2 gap-y-2 text-xs text-gray-600">
                                <span class="font-medium text-gray-900">{{ $item['noLab'] }}</span>
                                <span class="text-gray-300">•</span>
                                <span>{{ $item['noOrder'] }}</span>

                                <span class="text-gray-300">•</span>

                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-semibold ring-1 {{ $kategoriChip($item['kategori']) }}">
                                    {{ $item['kategori'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endsection
