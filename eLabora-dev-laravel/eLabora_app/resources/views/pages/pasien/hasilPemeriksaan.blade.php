@extends('layouts.app', ['sidebar' => 'pasien'])

@section('title', 'Hasil Pemeriksaan')

@section('content')
    @php
        $kategoriAktif = $kategori ?? strtolower(request('kategori', 'semua'));
        $qAktif = $q ?? request('q', '');

        $tabs = [
            'semua' => 'Semua',
            'patologi' => 'Patologi',
            'anatomi' => 'Anatomi',
            'mikrobiologi' => 'Mikrobiologi',
        ];

        $statusLabel = function ($s) {
            return match (strtoupper((string) $s)) {
                'HASIL_TERSEDIA' => 'Hasil Tersedia',
                'MENUNGGU_HASIL' => 'Menunggu Hasil',
                'DIBATALKAN' => 'Dibatalkan',
                default => $s ?: '-',
            };
        };

        $statusClass = function ($s) {
            return match (strtoupper((string) $s)) {
                'HASIL_TERSEDIA' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                'DIBATALKAN' => 'bg-rose-50 text-rose-700 ring-rose-200',
                default => 'bg-amber-50 text-amber-800 ring-amber-200',
            };
        };

        $iconClass = function ($k) {
            return match (strtolower((string) $k)) {
                'anatomi' => 'bg-violet-50 text-violet-700 ring-violet-200',
                'mikrobiologi' => 'bg-sky-50 text-sky-700 ring-sky-200',
                default => 'bg-orange-50 text-orange-700 ring-orange-200',
            };
        };
    @endphp

    <div class="max-w-4xl space-y-5">

        <div>
            <h1 class="text-xl font-semibold text-gray-900">Hasil Pemeriksaan</h1>
            <p class="text-sm text-gray-500">
                Lihat hasil pemeriksaan laboratorium berdasarkan kategori dan nomor lab.
            </p>
        </div>

        <form method="GET" action="{{ url('/hasil-pemeriksaan') }}" class="space-y-3">
            <input type="hidden" name="kategori" value="{{ $kategoriAktif }}">

            <div class="relative">
                <input type="text" name="q" value="{{ $qAktif }}" placeholder="Cari berdasarkan nomor lab" class="w-full px-4 py-3 border border-[#dce1f2] rounded-xl text-sm
                   focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white" />
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2
                   rounded-lg px-3 py-2 text-sm bg-indigo-600 text-white hover:bg-indigo-700">
                    Cari
                </button>
            </div>
        </form>

        <div class="flex flex-wrap gap-3">
            @foreach($tabs as $key => $label)
                <a href="{{ url('/hasil-pemeriksaan?kategori=' . $key . '&q=' . $qAktif) }}" class="px-6 py-2 rounded-xl text-sm
                  {{ $kategoriAktif === $key
                ? 'bg-indigo-600 text-white shadow'
                : 'bg-[#eef1f8] text-gray-800 hover:bg-[#e6eaf5]' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @if(empty($items) || count($items) === 0)
            <div class="rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center">
                <p class="text-sm text-gray-600">Hasil pemeriksaan tidak ditemukan.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($items as $it)
                    @php
                        $kategoriNama = (string) ($it['kategori_nama'] ?? '-');
                        $judul = "Pemeriksaan {$kategoriNama}";
                        $noLab = $it['no_lab'] ?? '-';
                        $tgl = $it['tgl_pemeriksaan']
                            ? date('d M Y, H:i', strtotime($it['tgl_pemeriksaan']))
                            : '-';
                        $status = $it['status_hasil'] ?? '-';
                    @endphp

                    <a href="{{ url('/detail-pemeriksaan/' . $it['pemeriksaan_id']) }}"
                        class="block rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-200 hover:shadow-md transition">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:gap-4">

                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-2xl ring-1 {{ $iconClass($kategoriNama) }}">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                    <path d="M9 3v5l-5 9a4 4 0 0 0 3.5 6h9a4 4 0 0 0 3.5-6l-5-9V3" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M9 8h6" stroke="currentColor" stroke-width="2" />
                                </svg>
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h3 class="text-base font-semibold text-gray-900">{{ $judul }}</h3>
                                        <p class="text-sm text-gray-600">{{ $tgl }}</p>
                                    </div>

                                    <span class="rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $statusClass($status) }}">
                                        {{ $statusLabel($status) }}
                                    </span>
                                </div>

                                <div class="mt-3 flex flex-wrap items-center gap-x-2 gap-y-2 text-xs text-gray-600">
                                    <span class="font-medium text-gray-900">{{ $noLab }}</span>
                                    <span class="text-gray-300">•</span>

                                    <span class="inline-flex items-center rounded-full px-2 py-0.5
                                         text-[11px] font-semibold ring-1 bg-gray-50 text-gray-700 ring-gray-200">
                                        {{ $kategoriNama }}
                                    </span>

                                    <span class="text-gray-300">•</span>
                                    <span>ID: {{ $it['pemeriksaan_id'] }}</span>
                                </div>
                            </div>

                        </div>
                    </a>
                @endforeach
            </div>
        @endif

    </div>
@endsection