@extends('layouts.app', ['sidebar' => 'dokter'])

@section('title', 'Manajemen Pasien')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6">
        <img src="{{ asset('assets/images/logo/Logo.png') }}" class="h-12">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">
                Manajemen Pasien
            </h1>
            <p class="text-sm text-gray-500">
                Daftar pasien dan detail pemeriksaan
            </p>
        </div>
    </div>

    {{-- SEARCH --}}
    <form method="GET" action="{{ url()->current() }}" class="mb-4">
        <div class="relative max-w-sm">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
            </span>

            <input
                type="text"
                id="searchInput"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari pasien"
                class="w-full pl-9 pr-3 py-2 border rounded-lg text-sm
                    focus:ring-indigo-500 focus:border-indigo-500"
            >
        </div>
    </form>



    {{-- DAFTAR PASIEN --}}
    <div class="bg-white rounded-xl shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b">
            <h2 class="font-semibold text-gray-800">Daftar Pasien</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">NIK</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($patients as $p)
                        <tr class="hover:bg-gray-50 {{ request('pasien') == $p['id'] ? 'bg-indigo-50' : '' }}">
                            <td class="px-6 py-4 font-medium">
                                {{ $p['nama'] }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $p['nik'] }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $p['email'] }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="?pasien={{ $p['id'] }}"
                                   class="px-4 py-2 text-xs border rounded-lg hover:bg-gray-100">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                                Tidak ada pasien
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- DETAIL PASIEN --}}
    @if($selectedPatient)
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="font-semibold text-gray-800 mb-4">
                Detail Pasien – {{ $selectedPatient['nama'] }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500">NIK</p>
                    <p class="font-medium">{{ $selectedPatient['nik'] }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Tanggal Lahir</p>
                    <p class="font-medium">{{ $selectedPatient['tgl_lahir'] }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">No Telepon</p>
                    <p class="font-medium">{{ $selectedPatient['no_telepon'] }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Email</p>
                    <p class="font-medium">{{ $selectedPatient['email'] }}</p>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection
