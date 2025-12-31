@extends('layouts.app', ['sidebar' => 'pasien'])

@section('title', 'Hasil Pemeriksaan Pasien')

@section('content')
    @php
        $tabs = [
            'Semua' => 'Semua',
            'Patologi' => 'Patologi',
            'Anatomi' => 'Anatomi',
            'Mikrobiologi' => 'Mikrobiologi',
        ];
    @endphp

    <div class="max-w-4xl space-y-5" x-data="{ filter: 'Semua' }">

        <div>
            <h1 class="text-xl font-semibold text-gray-900">Hasil Pemeriksaan</h1>
            <p class="text-sm text-gray-500">
                Lihat hasil pemeriksaan laboratorium berdasarkan kategori.
            </p>
        </div>

        <div>
            <input type="text" placeholder="Cari berdasarkan nomor lab" class="w-full px-4 py-3 border border-[#dce1f2] rounded-xl text-sm
                 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white" />
        </div>

        <div class="flex flex-wrap gap-3">
            @foreach($tabs as $key => $label)
                <button @click="filter = '{{ $key }}'" class="px-6 py-2 rounded-xl text-sm transition
                  " :class="filter === '{{ $key }}'
                  ? 'bg-indigo-600 text-white shadow'
                  : 'bg-[#eef1f8] text-gray-800 hover:bg-[#e6eaf5]'">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        @if(empty($items) || count($items) === 0)
            <div class="rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center">
                <p class="text-sm text-gray-600">Hasil tidak ditemukan.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($items as $it)
                    @php
                        $pemeriksaanId = $it['pemeriksaan_id'] ?? null;
                        $kategoriNama = (string) ($it['kategori_nama'] ?? '-');
                        $noLab = (string) ($it['no_lab'] ?? '-');
                        $tgl = $it['tgl_pemeriksaan'] ?? null;
                        $status = $it['status_hasil'] ?? 'HASIL_TERSEDIA';

                        $judul = $kategoriNama !== '-' ? "Pemeriksaan {$kategoriNama}" : "Pemeriksaan Lab";
                        $tglText = $tgl ? date('d M Y, H:i', strtotime($tgl)) : '-';

                        $statusLabel = match (strtoupper($status)) {
                            'HASIL_TERSEDIA' => 'Hasil Tersedia',
                            'MENUNGGU_HASIL' => 'Menunggu Hasil',
                            'DIBATALKAN' => 'Dibatalkan',
                            default => $status,
                        };

                        $statusClass = match (strtoupper($status)) {
                            'HASIL_TERSEDIA' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                            'DIBATALKAN' => 'bg-rose-50 text-rose-700 ring-rose-200',
                            default => 'bg-amber-50 text-amber-800 ring-amber-200',
                        };

                        $iconClass = match (strtolower($kategoriNama)) {
                            'anatomi' => 'bg-violet-50 text-violet-700 ring-violet-200',
                            'mikrobiologi' => 'bg-sky-50 text-sky-700 ring-sky-200',
                            default => 'bg-orange-50 text-orange-700 ring-orange-200',
                        };
                    @endphp

                    <a x-show="filter === 'Semua' || filter === '{{ $kategoriNama }}'"
                        href="{{ url('/detail-pemeriksaan/' . $pemeriksaanId) }}" class="block">
                        <article class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-200
                               hover:shadow-md transition">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:gap-4">

                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl ring-1 {{ $iconClass }}">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                        <path d="M9 3v5l-5 9a4 4 0 0 0 3.5 6h9a4 4 0 0 0 3.5-6l-5-9V3" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M9 8h6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <h3 class="truncate text-base font-semibold text-gray-900">
                                                {{ $judul }}
                                            </h3>
                                            <p class="mt-0.5 text-sm text-gray-600">
                                                {{ $tglText }}
                                            </p>
                                        </div>

                                        <span
                                            class="shrink-0 rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </div>

                                    <div class="mt-3 flex flex-wrap items-center gap-x-2 gap-y-2 text-xs text-gray-600">
                                        <span class="font-medium text-gray-900">{{ $noLab }}</span>
                                        <span class="text-gray-300">•</span>

                                        <span class="inline-flex items-center rounded-full px-2 py-0.5
                                       text-[11px] font-semibold ring-1
                                       bg-gray-50 text-gray-700 ring-gray-200">
                                            {{ $kategoriNama }}
                                        </span>

                                        @if($pemeriksaanId)
                                            <span class="text-gray-300">•</span>
                                            <span>ID: {{ $pemeriksaanId }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    </a>
                @endforeach
            </div>
        @endif

    </div>
@endsection