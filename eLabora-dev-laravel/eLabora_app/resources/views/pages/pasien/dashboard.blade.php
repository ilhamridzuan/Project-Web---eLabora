@extends('layouts.app', ['sidebar' => 'pasien'])

@section('title', 'Beranda Pasien')

@section('content')
<div class="space-y-8">

    {{-- Header --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Beranda</h2>
    </div>

    {{-- Flowbite Carousel --}}
    <div id="default-carousel" class="relative w-full rounded-xl overflow-hidden shadow-lg" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-64 overflow-hidden rounded-xl md:h-96">
            <!-- Item 1 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('assets/images/sliders/slides1.png') }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Slide 1">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('assets/images/sliders/slides2.png') }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Slide 2">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('assets/images/sliders/slides3.png') }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Slide 3">
            </div>
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
            <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
        </div>
        <!-- Slider controls -->
        <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>

    {{-- Menu Cards --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ url('/pendaftaran') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 transition-all hover:shadow-lg">
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-indigo-100">
                    <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h5 class="text-xl font-semibold tracking-tight text-gray-900">Pendaftaran</h5>
            </div>
        </a>

        <a href="{{ url('/hasil-pemeriksaan') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 transition-all hover:shadow-lg">
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-indigo-100">
                    <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h5 class="text-xl font-semibold tracking-tight text-gray-900">Cek Hasil Pemeriksaan</h5>
            </div>
        </a>

        <a href="{{ url('/riwayat') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 transition-all hover:shadow-lg">
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-indigo-100">
                    <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h5 class="text-xl font-semibold tracking-tight text-gray-900">Riwayat Pemeriksaan</h5>
            </div>
        </a>
    </section>

    {{-- Queue Section --}}
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Tabel Antrian --}}
        <div class="lg:col-span-2">
            <div class="mb-4">
                <h3 class="text-xl font-bold text-gray-900">Daftar Antrian Laboratorium Hari Ini</h3>
                <p class="text-sm text-gray-500">Update otomatis sesuai data sistem.</p>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-center text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">No. Antrian</th>
                            <th scope="col" class="px-6 py-3">Jenis Pemeriksaan</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($queues ?? [] as $q)
                        @php
                        $status = strtoupper($q['status'] ?? '-');

                        // Badge color mapping
                        $badgeClass = 'bg-gray-100 text-gray-800';
                        if ($status === 'MENUNGGU' || $status === 'PENDING') $badgeClass = 'bg-yellow-100 text-yellow-800';
                        elseif ($status === 'DILAYANI' || $status === 'PROSES') $badgeClass = 'bg-blue-100 text-blue-800';
                        elseif ($status === 'SELESAI' || $status === 'DONE') $badgeClass = 'bg-green-100 text-green-800';
                        elseif ($status === 'DIBATALKAN' || $status === 'BATAL' || $status === 'CANCEL') $badgeClass = 'bg-red-100 text-red-800';

                        $jenis = $q['kategori_nama'] ?? $q['kategori'] ?? $q['no_lab'] ?? '-';

                        $waktu = '-';
                        if (!empty($q['jadwal_pemeriksaan_at'])) {
                            try {
                                $waktu = \Carbon\Carbon::parse($q['jadwal_pemeriksaan_at'])->format('H:i');
                            } catch (\Throwable $e) {}
                        }
                        @endphp

                        <tr class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $q['no_antrian'] ?? '-' }}
                            </th>
                            <td class="px-6 py-4">{{ $jenis }}</td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-medium px-2.5 py-0.5 rounded {{ $badgeClass }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $waktu }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center">
                                <p class="text-sm font-semibold text-gray-700">Belum ada antrian hari ini</p>
                                <p class="text-xs text-gray-500 mt-1">Data antrian akan tampil ketika ada pendaftaran.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Info Antrian Saat Ini --}}
        <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow">
            <h5 class="mb-4 text-xl font-bold text-center text-gray-900">Informasi Antrian Saat Ini</h5>

            @if(!empty($current))
            <div class="p-5 bg-gradient-to-br from-indigo-50 to-white border border-indigo-100 rounded-lg">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-xs text-gray-500">No Antrian</p>
                        <p class="mt-1 text-3xl font-bold text-indigo-600">
                            {{ $current['no_antrian'] ?? '-' }}
                        </p>
                    </div>

                    @php
                    $stNow = strtoupper($current['status'] ?? 'DILAYANI');
                    @endphp
                    <span class="text-xs font-medium px-2.5 py-0.5 rounded bg-blue-100 text-blue-800">
                        {{ $stNow }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="p-3 bg-white border border-gray-200 rounded-lg">
                        <p class="text-xs text-gray-500">No Lab</p>
                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $current['no_lab'] ?? '-' }}
                        </p>
                    </div>

                    <div class="p-3 bg-white border border-gray-200 rounded-lg text-right">
                        <p class="text-xs text-gray-500">Jadwal</p>
                        <p class="mt-1 font-semibold text-gray-900 text-xs">
                            @if(!empty($current['jadwal_pemeriksaan_at']))
                            {{ \Carbon\Carbon::parse($current['jadwal_pemeriksaan_at'])->format('d M Y, H:i') }}
                            @else
                            -
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @else
            <div class="flex items-center justify-center h-32 text-gray-400">
                Belum ada pasien
            </div>
            @endif
        </div>

    </section>

</div>
@endsection