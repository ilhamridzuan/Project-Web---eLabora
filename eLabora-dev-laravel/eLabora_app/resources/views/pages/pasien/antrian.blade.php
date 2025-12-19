@extends('layouts.app', ['sidebar' => 'pasien'])

@section('title', 'Antrian Pasien')

@section('content')
<div class="max-w-6xl mx-auto">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <img src="{{ asset('assets/images/logo/Logo.png') }}" class="h-12">
            <div>
                <h1 class="text-lg font-semibold text-gray-800">
                    Pendaftaran Pemeriksaan Laboratorium
                </h1>
                <p class="text-sm text-gray-500">
                    Sistem Pendaftaran Tes Lab Online
                </p>
            </div>
        </div>

        <div class="flex bg-gray-200 rounded-full p-1">
            <a href="{{ url('/pendaftaran') }}" class="px-5 py-2 text-sm text-gray-600">
                Pendaftaran
            </a>
            <a href="{{ url('/antrian') }}"
               class="px-5 py-2 text-sm font-medium bg-white rounded-full shadow">
                Antrian
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        <div class="bg-indigo-600 text-white rounded-xl p-5 text-center">
            <span class="bg-white text-indigo-600 text-xs font-semibold px-3 py-1 rounded-full">
                Live
            </span>
            <h1 class="text-4xl font-bold mt-3">001</h1>
            <p class="text-sm">Nomor Antrian Saat Ini</p>
        </div>

        <div class="bg-white rounded-xl shadow p-5 text-center">
            <h2 class="text-3xl font-bold">0</h2>
            <p class="text-sm text-gray-500">Pasien Menunggu</p>
        </div>

        <div class="bg-white rounded-xl shadow p-5 text-center">
            <h2 class="text-3xl font-bold">0</h2>
            <p class="text-sm text-gray-500">Sudah Dilayani</p>
        </div>

        <div class="bg-white rounded-xl shadow p-5 text-center">
            <h2 class="text-3xl font-bold">0 / 20</h2>
            <p class="text-sm text-gray-500">Kapasitas Hari Ini</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="bg-white border-2 border-indigo-300 rounded-xl p-6 flex flex-col">
            <h3 class="font-semibold mb-4">Sedang Dilayani</h3>

            <div class="flex-1 flex items-center justify-center text-gray-400">
                Belum ada pasien
            </div>

            <div class="flex justify-between mt-4">
                <button class="px-4 py-2 bg-gray-200 rounded-lg">
                    Sebelumnya
                </button>
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg">
                    Selanjutnya
                </button>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white rounded-xl shadow p-6 ">
            <div class="mb-4">
                <h3 class="font-semibold text-gray-800">
                    Daftar Antrian Hari Ini
                </h3>
                
                <p class="text-sm text-gray-500 mt-1">
                    <span id="queue-date">Sabtu, 25 Oktober 2025</span>
                    <span class="mx-1">•</span>
                    <span class="font-medium text-indigo-600">
                        <span id="queue-time">00:00:00</span> WIB
                    </span>
                </p>
                <span class="bg-gray-100 px-3 py-1 rounded-lg text-sm whitespace-nowrap">Total: 0</span>
                
            </div>
            <div class="text-center text-gray-400 py-12">
                Belum ada pendaftaran hari ini
            </div>
        </div>
    </div>

</div>
<script>
    function updateDateTime() {
        const now = new Date();

        const dateOptions = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };

        const timeOptions = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };

        document.getElementById('queue-date').textContent =
            now.toLocaleDateString('id-ID', dateOptions);

        document.getElementById('queue-time').textContent =
            now.toLocaleTimeString('id-ID', timeOptions);
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>

@endsection