@extends('layouts.app', ['sidebar' => 'admin'])

@section('title', 'Manajemen Antrian')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Manajemen Antrian</h2>
            <p class="text-sm text-gray-500 mt-1">
                Daftar antrian hari ini
                @if($tanggal) <span class="font-medium text-gray-900">({{ $tanggal }})</span> @endif
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('antrian.petugas') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-4 py-2">
                Refresh
            </a>
        </div>
    </div>

    {{-- Flowbite Alerts --}}
    @if(session('success'))
        <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Success</span>
            <div>{{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Error</span>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    {{-- Flowbite Table --}}
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-center text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">No Antrian</th>
                    <th scope="col" class="px-6 py-3">No Lab</th>
                    <th scope="col" class="px-6 py-3">Pasien</th>
                    <th scope="col" class="px-6 py-3">Jadwal</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($queues as $i => $q)
                    @php
                        $status = strtoupper($q['status'] ?? '-');

                        $badgeClass = 'bg-gray-100 text-gray-800';
                        if ($status === 'MENUNGGU') $badgeClass = 'bg-yellow-100 text-yellow-800';
                        if ($status === 'DILAYANI') $badgeClass = 'bg-blue-100 text-blue-800';
                        if ($status === 'SELESAI') $badgeClass = 'bg-green-100 text-green-800';
                        if ($status === 'DIBATALKAN') $badgeClass = 'bg-red-100 text-red-800';

                        $isFinal = in_array($status, ['SELESAI', 'DIBATALKAN'], true);
                    @endphp

                    <tr class="bg-white border-b hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $q['no_antrian'] ?? '-' }}
                        </th>
                        <td class="px-6 py-4">{{ $q['no_lab'] ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $q['nama'] ?? '-' }}</div>
                            <div class="text-xs text-gray-500">NIK: {{ $q['nik'] ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            {{ $q['jadwal_pemeriksaan_at'] ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-medium px-2.5 py-0.5 rounded {{ $badgeClass }}">
                                {{ $status }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-2 justify-center">
                                {{-- CALL --}}
                                <form method="POST" action="{{ route('antrian.call', $q['id']) }}">
                                    @csrf
                                    <button type="submit" class="font-medium text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-100 rounded-lg text-xs px-3 py-1.5 {{ $isFinal ? 'opacity-40 cursor-not-allowed' : '' }}" {{ $isFinal ? 'disabled' : '' }}>
                                        Call
                                    </button>
                                </form>

                                {{-- NEXT --}}
                                <form method="POST" action="{{ route('antrian.next', $q['id']) }}">
                                    @csrf
                                    <button type="submit" class="font-medium text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-100 rounded-lg text-xs px-3 py-1.5 {{ $isFinal ? 'opacity-40 cursor-not-allowed' : '' }}" {{ $isFinal ? 'disabled' : '' }}>
                                        Next
                                    </button>
                                </form>

                                {{-- CANCEL --}}
                                <form method="POST" action="{{ route('antrian.cancel', $q['id']) }}" onsubmit="return confirm('Batalkan antrian ini?')">
                                    @csrf
                                    <button type="submit" class="font-medium text-red-700 bg-white border border-red-300 hover:bg-red-50 focus:ring-4 focus:outline-none focus:ring-red-100 rounded-lg text-xs px-3 py-1.5 {{ $isFinal ? 'opacity-40 cursor-not-allowed' : '' }}" {{ $isFinal ? 'disabled' : '' }}>
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center">
                            <p class="text-sm font-semibold text-gray-700">Tidak ada antrian hari ini</p>
                            <p class="text-xs text-gray-500 mt-1">Data akan muncul ketika ada pendaftaran masuk.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
