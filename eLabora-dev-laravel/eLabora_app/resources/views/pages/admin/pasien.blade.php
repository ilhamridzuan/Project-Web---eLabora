@extends('layouts.app', ['sidebar' => 'admin'])

@section('title', 'Manajemen Pasien')

@section('content')
<div class="space-y-6">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-slate-800">Manajemen Pasien</h2>
            <p class="mt-1 text-sm text-slate-500">Daftar seluruh pasien yang terdaftar pada sistem.</p>
        </div>

        {{-- (opsional) search jika endpoint mendukung q --}}
        <form method="GET" action="{{ route('petugas.pasien') }}" class="w-full sm:w-[360px]">
            <div class="relative">
                <input
                    type="text"
                    name="q"
                    value="{{ $q ?? '' }}"
                    placeholder="Cari nama / NIK / no. telp..."
                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 pr-10 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300" />
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18.5a7.5 7.5 0 006.15-3.85z" />
                    </svg>
                </span>
            </div>
        </form>
    </div>

    {{-- ================= ALERTS ================= --}}
    @if(!empty($errorMessage))
    <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 text-sm">
        {{ $errorMessage }}
    </div>
    @endif

    @if(session('success'))
    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 text-sm">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 text-sm">
        {{ session('error') }}
    </div>
    @endif

    {{-- ================= TABLE ================= --}}
    <div class="rounded-xl bg-white shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-center">
                        <th class="px-4 py-3 w-16">No</th>
                        <th class="px-4 py-3 text-left">Pasien</th>
                        <th class="px-4 py-3">NIK</th>
                        <th class="px-4 py-3">No. Telp</th>
                        <th class="px-4 py-3 text-left">Alamat</th>
                        <th class="px-4 py-3">Terdaftar</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse(($patients ?? []) as $p)
                    @php
                    $nama = $p['nama'] ?? $p['name'] ?? $p['pasien_nama'] ?? '-';
                    $nik = $p['nik'] ?? '-';
                    $telp = $p['no_telp'] ?? $p['telp'] ?? $p['phone'] ?? '-';
                    $alamat = $p['alamat'] ?? '-';

                    $created = $p['created_at'] ?? null;
                    $createdText = $created ? $created : '-';
                    @endphp

                    <tr class="hover:bg-slate-50/60">
                        <td class="px-4 py-3 text-slate-600 tabular-nums text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-3 text-left">
                            <div class="font-medium text-slate-800">{{ $nama }}</div>
                            @if(!empty($p['id']))
                            <div class="text-xs text-slate-500">ID: {{ $p['id'] }}</div>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-slate-700 text-center tabular-nums">{{ $nik }}</td>
                        <td class="px-4 py-3 text-slate-700 text-center tabular-nums">{{ $telp }}</td>

                        <td class="px-4 py-3 text-left text-slate-700">
                            <div class="max-w-[420px] truncate">{{ $alamat }}</div>
                        </td>

                        <td class="px-4 py-3 text-slate-600 text-center">{{ $createdText }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center">
                            <p class="text-sm font-semibold text-slate-700">Belum ada data pasien</p>
                            <p class="text-xs text-slate-500 mt-1">Data akan muncul setelah pasien terdaftar di sistem.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>


            </table>
        </div>
    </div>

</div>
@endsection