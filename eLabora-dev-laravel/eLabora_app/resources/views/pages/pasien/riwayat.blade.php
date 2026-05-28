@extends('layouts.app', ['sidebar' => 'pasien'])

@section('title', 'Riwayat Pemeriksaan')

@section('content')
@php
$kategoriAktif = $kategori ?? strtolower(request('kategori', 'semua'));
$qAktif = $q ?? request('q', '');
$errorMessage = $errorMessage ?? null;

$tabs = [
'semua' => 'Semua',
'patologi' => 'Patologi',
'anatomi' => 'Anatomi',
'mikrobiologi' => 'Mikrobiologi',
];

$statusLabel = function ($s) {
$s = strtoupper((string) $s);
return match ($s) {
'HASIL_TERSEDIA' => 'Hasil Tersedia',
'DIBATALKAN' => 'Dibatalkan',
'MENUNGGU_HASIL' => 'Menunggu Hasil',
default => $s ?: '-',
};
};

$statusClass = function ($s) {
$s = strtoupper((string) $s);
return match ($s) {
'HASIL_TERSEDIA' => 'bg-green-100 text-green-800',
'DIBATALKAN' => 'bg-red-100 text-red-800',
default => 'bg-yellow-100 text-yellow-800',
};
};

$iconClass = function ($k) {
return match (strtolower((string) $k)) {
'anatomi' => 'bg-purple-100 text-purple-700',
'mikrobiologi' => 'bg-blue-100 text-blue-700',
default => 'bg-orange-100 text-orange-700',
};
};
@endphp

<div class="max-w-7xl mx-auto space-y-5">

  <div>
    <h1 class="text-2xl font-bold text-gray-900">Riwayat Pemeriksaan</h1>
    <p class="text-sm text-gray-500">
      Lihat riwayat pemeriksaan berdasarkan kategori dan nomor lab.
    </p>
  </div>

  @if (!empty($errorMessage))
    <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
      <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
      </svg>
      <span class="sr-only">Error</span>
      <div>{{ $errorMessage }}</div>
    </div>
  @endif

  {{-- Flowbite Simple Search Bar --}}
  <form method="GET" action="{{ route('riwayat') }}">
    <input type="hidden" name="kategori" value="{{ $kategoriAktif }}">
    
    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
    <div class="relative">
      <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
        </svg>
      </div>
      <input type="search" name="q" id="default-search" value="{{ $qAktif }}" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Cari berdasarkan nomor lab..." />
      <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-4 py-2">
        Cari
      </button>
    </div>
  </form>

  {{-- Flowbite Pills/Tabs --}}
  <div class="flex flex-wrap gap-2">
    @foreach ($tabs as $key => $label)
      <a href="{{ route('riwayat', ['kategori' => $key, 'q' => $qAktif]) }}" class="text-sm font-medium px-5 py-2.5 rounded-lg {{ $kategoriAktif === $key ? 'text-white bg-indigo-600' : 'text-gray-900 bg-white border border-gray-300 hover:bg-gray-100' }}">
        {{ $label }}
      </a>
    @endforeach
  </div>

  {{-- List Cards --}}
  @if (empty($items) || count($items) === 0)
    <div class="flex items-center justify-center p-10 bg-white border-2 border-gray-300 border-dashed rounded-lg">
      <p class="text-sm text-gray-500">Tidak ada riwayat yang sesuai.</p>
    </div>
  @else
    <div class="space-y-4">
      @foreach ($items as $it)
        @php
        $pemeriksaanId = $it['pemeriksaan_id'] ?? null;
        $kategoriNama = (string) ($it['kategori_nama'] ?? '-');
        $noLab = (string) ($it['no_lab'] ?? '-');
        $tgl = $it['tgl_pemeriksaan'] ?? null;
        $status = $it['status_hasil'] ?? '-';

        $judul = $kategoriNama !== '-' ? "Pemeriksaan {$kategoriNama}" : 'Pemeriksaan Lab';
        $tglText = $tgl ? date('d M Y, H:i', strtotime($tgl)) : '-';
        @endphp

        {{-- Flowbite Card --}}
        <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
          <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:gap-4">

            <div class="flex h-12 w-12 items-center justify-center rounded-lg {{ $iconClass($kategoriNama) }}">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M9 3v5l-5 9a4 4 0 0 0 3.5 6h9a4 4 0 0 0 3.5-6l-5-9V3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M9 8h6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              </svg>
            </div>

            <div class="min-w-0 flex-1">
              <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                  <h5 class="text-lg font-bold tracking-tight text-gray-900">
                    {{ $judul }}
                  </h5>
                  <p class="mt-1 text-sm text-gray-600">
                    {{ $tglText }}
                  </p>
                </div>

                <span class="text-xs font-medium px-2.5 py-0.5 rounded {{ $statusClass($status) }}">
                  {{ $statusLabel($status) }}
                </span>
              </div>

              <div class="mt-3 flex flex-wrap items-center gap-x-2 gap-y-2 text-xs text-gray-600">
                <span class="font-semibold text-gray-900">{{ $noLab }}</span>
                <span class="text-gray-300">•</span>

                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">
                  {{ $kategoriNama }}
                </span>

                @if (!empty($pemeriksaanId))
                  <span class="text-gray-300">•</span>
                  <span>ID: {{ $pemeriksaanId }}</span>
                @endif
              </div>

            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif

</div>
@endsection