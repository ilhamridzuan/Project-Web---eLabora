@extends('layouts.app', ['sidebar' => 'dokter'])

@section('title', 'Dashboard Dokter')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <img src="{{ asset('assets/images/logo/Logo.png') }}" class="h-12">
            <div>
                <h1 class="text-lg font-semibold text-gray-800">
                    Dashboard Dokter
                </h1>
                <p class="text-sm text-gray-500">
                    Monitoring Antrian & Pemeriksaan Pasien
                </p>
            </div>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-indigo-600 text-white rounded-xl shadow p-5 text-center">
            <span class="text-xs font-semibold bg-white text-indigo-600 px-3 py-1 rounded-full">
                Aktif
            </span>
            <h2 class="text-3xl font-bold mt-3">
                {{ $current['no_antrian'] ?? '-' }}
            </h2>
            <p class="text-sm">Antrian Saat Ini</p>
        </div>

        <div class="bg-white rounded-xl shadow p-5 text-center">
            <h2 class="text-3xl font-bold">{{ $stats['dilayani'] ?? 0 }}</h2>
            <br>
            <p class="text-sm text-gray-500">Pasien Dilayani Hari Ini</p>
        </div>

        <div class="bg-white rounded-xl shadow p-5 text-center">
            <h2 class="text-3xl font-bold">{{ $stats['menunggu'] ?? 0 }}</h2>
            <br>
            <p class="text-sm text-gray-500">Pasien Menunggu</p>
        </div>

        <div class="bg-white rounded-xl shadow p-5 text-center">
            <h2 class="text-3xl font-bold">{{ $stats['total'] ?? 0 }}</h2>
            <br>
            <p class="text-sm text-gray-500">Total Pemeriksaan</p>
        </div>

    </div>

    {{-- Konten --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Pemeriksaan Saat Ini --}}
        <div class="bg-white border-2 border-indigo-300 rounded-xl p-6 flex flex-col">
            <h3 class="font-semibold mb-4">Pemeriksaan Saat Ini</h3>

            @if($current)
                <div class="rounded-xl bg-indigo-50 p-4 border border-indigo-100">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs text-gray-500">No Antrian</p>
                            <p class="text-2xl font-bold text-indigo-700">
                                {{ $current['no_antrian'] }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">Ruangan</p>
                            <p class="font-semibold text-gray-800">
                                {{ $current['no_lab'] }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <p class="text-xs text-gray-500">Jadwal</p>
                        <p class="text-sm text-gray-800">
                            {{ $current['jadwal_pemeriksaan_at'] }}
                        </p>
                    </div>

                    <div class="mt-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-600 text-white">
                            {{ $current['status'] }}
                        </span>
                    </div>
                </div>
            @else
                <div class="flex-1 flex items-center justify-center text-gray-400">
                    Tidak ada pemeriksaan aktif
                </div>
            @endif
        </div>

        {{-- Daftar Antrian --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">

            <div class="mb-4 flex items-center justify-between gap-4">
                <div>
                    <h3 class="font-semibold text-gray-800">
                        Daftar Antrian Hari Ini
                    </h3>
                    
                    <p class="text-sm text-gray-500 mt-1">
                        <span id="queue-date">{{ $tanggal ?? '-' }}</span>
                        <span class="mx-1">•</span>
                        <span class="font-medium text-indigo-600">
                            <span id="queue-time">00:00:00</span> WIB
                        </span>
                    </p>

                </div>

                <span class="bg-gray-100 px-3 py-1 rounded-lg text-sm">
                    Total: {{ $stats['total'] ?? 0 }}
                </span>
            </div>

            @if(!empty($queues))
                <div class="space-y-3">
                    @foreach($queues as $q)
                        @php
                            $status = strtoupper($q['status'] ?? '-');
                            $badge = 'bg-gray-100 text-gray-700';

                            if ($status === 'MENUNGGU') $badge = 'bg-amber-100 text-amber-700';
                            elseif ($status === 'DILAYANI') $badge = 'bg-indigo-100 text-indigo-700';
                            elseif ($status === 'SELESAI') $badge = 'bg-green-100 text-green-700';
                        @endphp

                        <div class="border rounded-xl p-4 flex items-start justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center font-bold text-indigo-700">
                                    {{ $q['no_antrian'] }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">
                                        Ruangan {{ $q['no_lab'] }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Jadwal: {{ $q['jadwal_pemeriksaan_at'] }}
                                    </p>
                                </div>
                            </div>

                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                {{ $status }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-gray-400 py-12">
                    Belum ada antrian hari ini
                </div>
            @endif

        </div>
    </div>
    <script>
        function updateDateTime() {
            const now = new Date();
            const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit' };

            const dateEl = document.getElementById('queue-date');
            if (dateEl && (dateEl.textContent || '').trim() === '-') {
                dateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);
            }

            document.getElementById('queue-time').textContent =
                now.toLocaleTimeString('id-ID', timeOptions);
        }

        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>

</div>
@endsection