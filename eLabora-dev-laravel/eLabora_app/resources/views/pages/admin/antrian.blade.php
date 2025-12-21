@extends('layouts.app', ['sidebar' => 'admin'])

@section('title', 'Manajemen Antrian')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-slate-800">Manajemen Antrian</h2>
            <p class="text-sm text-slate-500 mt-1">
                Daftar antrian hari ini
                @if($tanggal) <span class="font-medium text-slate-700">({{ $tanggal }})</span> @endif
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('antrian.petugas') }}"
               class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                Refresh
            </a>
        </div>
    </div>

    {{-- Flash message --}}
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

    {{-- Table --}}
    <div class="rounded-xl bg-white shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left">
                        <th class="px-4 py-3 font-semibold text-slate-700 w-16">No</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">No Antrian</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">No Lab</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Pasien</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Jadwal</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Status</th>
                        <th class="px-4 py-3 font-semibold text-slate-700 w-56">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($queues as $i => $q)
                        @php
                            $status = strtoupper($q['status'] ?? '-');

                            $badge = 'bg-slate-100 text-slate-700 border-slate-200';
                            if ($status === 'MENUNGGU') $badge = 'bg-amber-50 text-amber-700 border-amber-200';
                            if ($status === 'DILAYANI') $badge = 'bg-indigo-50 text-indigo-700 border-indigo-200';
                            if ($status === 'SELESAI') $badge = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                            if ($status === 'DIBATALKAN') $badge = 'bg-rose-50 text-rose-700 border-rose-200';

                            // Optional: disable actions for final states
                            $isFinal = in_array($status, ['SELESAI', 'DIBATALKAN'], true);
                        @endphp

                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-3 text-slate-600">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 text-slate-800 font-semibold tabular-nums">{{ $q['no_antrian'] ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $q['no_lab'] ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-slate-800">{{ $q['nama'] ?? '-' }}</div>
                                <div class="text-xs text-slate-500">NIK: {{ $q['nik'] ?? '-' }}</div>
                            </td>
                            <td class="px-4 py-3 text-slate-600 tabular-nums">
                                {{ $q['jadwal_pemeriksaan_at'] ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg border text-xs font-semibold {{ $badge }}">
                                    {{ $status }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-2">
                                    {{-- CALL --}}
                                    <form method="POST" action="{{ route('antrian.call', $q['id']) }}">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="px-2.5 py-1.5 rounded-lg text-xs font-semibold border border-slate-300 hover:bg-slate-50
                                            {{ $isFinal ? 'opacity-40 cursor-not-allowed' : '' }}"
                                            {{ $isFinal ? 'disabled' : '' }}>
                                            Call
                                        </button>
                                    </form>

                                    {{-- NEXT --}}
                                    <form method="POST" action="{{ route('antrian.next', $q['id']) }}">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="px-2.5 py-1.5 rounded-lg text-xs font-semibold border border-slate-300 hover:bg-slate-50
                                            {{ $isFinal ? 'opacity-40 cursor-not-allowed' : '' }}"
                                            {{ $isFinal ? 'disabled' : '' }}>
                                            Next
                                        </button>
                                    </form>

                                    {{-- CANCEL --}}
                                    <form method="POST" action="{{ route('antrian.cancel', $q['id']) }}"
                                          onsubmit="return confirm('Batalkan antrian ini?')">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="px-2.5 py-1.5 rounded-lg text-xs font-semibold border border-rose-300 text-rose-700 hover:bg-rose-50
                                            {{ $isFinal ? 'opacity-40 cursor-not-allowed' : '' }}"
                                            {{ $isFinal ? 'disabled' : '' }}>
                                            Cancel
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center">
                                <p class="text-sm font-semibold text-slate-700">Tidak ada antrian hari ini</p>
                                <p class="text-xs text-slate-500 mt-1">Data akan muncul ketika ada pendaftaran masuk.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
