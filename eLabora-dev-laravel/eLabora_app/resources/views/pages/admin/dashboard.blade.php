@extends('layouts.app', ['sidebar' => 'admin'])

@section('title', 'Dashboard Petugas')

@section('content')
<div class="space-y-8">

    {{-- Header --}}
    <div>
        <h2 class="text-2xl font-semibold text-slate-800">Dashboard Petugas</h2>
        <p class="text-sm text-slate-500 mt-1">Ringkasan antrian hari ini & riwayat perubahan data.</p>
    </div>

    {{-- SECTION 1: Ringkasan Antrian + Jam Realtime --}}
    <section class="space-y-4" x-data="realtimeClock()" x-init="start()">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-slate-800">Antrian Hari Ini</h3>
                <p class="text-sm text-slate-500">Update otomatis sesuai data sistem.</p>
            </div>

            {{-- Realtime Clock --}}
            <div class="inline-flex items-center gap-2 rounded-xl bg-white shadow-sm border border-slate-200 px-4 py-2">
                <span class="text-xs font-medium text-slate-500">Waktu</span>
                <span class="h-4 w-px bg-slate-200"></span>
                <span class="text-sm font-semibold text-slate-800 tabular-nums" x-text="nowText">--</span>
            </div>
        </div>

        @php
        // Nilai default biar halaman tetap aman kalau controller belum kirim data.
        $queueStats = $queueStats ?? [
        'total' => 0,
        'menunggu' => 0,
        'selesai' => 0,
        'dibatalkan' => 0,
        ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            {{-- Total Antrian --}}
            <div class="rounded-xl bg-white shadow-sm border border-slate-200 p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Total Antrian</p>
                        <p class="mt-2 text-3xl font-semibold text-slate-800">
                            {{ $queueStats['total'] ?? 0 }}
                        </p>
                    </div>
                    <div class="rounded-lg bg-indigo-50 border border-indigo-100 p-2">
                        {{-- Icon --}}
                        <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3M5 11h14M7 21h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-3 text-xs text-slate-500">Jumlah seluruh pendaftaran antrian hari ini.</p>
            </div>

            {{-- Sisa Antrian --}}
            <div class="rounded-xl bg-white shadow-sm border border-slate-200 p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Sisa Antrian</p>
                        <p class="mt-2 text-3xl font-semibold text-slate-800">
                            {{ $queueStats['menunggu'] ?? 0 }}
                        </p>
                    </div>
                    <div class="rounded-lg bg-amber-50 border border-amber-100 p-2">
                        <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-3 text-xs text-slate-500">Antrian yang belum diproses/selesai.</p>
            </div>

            {{-- Selesai --}}
            <div class="rounded-xl bg-white shadow-sm border border-slate-200 p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Sudah Selesai</p>
                        <p class="mt-2 text-3xl font-semibold text-slate-800">
                            {{ $queueStats['selesai'] ?? 0 }}
                        </p>
                    </div>
                    <div class="rounded-lg bg-emerald-50 border border-emerald-100 p-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m7 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-3 text-xs text-slate-500">Antrian yang sudah diproses sampai selesai.</p>
            </div>

            {{-- Dibatalkan --}}
            <div class="rounded-xl bg-white shadow-sm border border-slate-200 p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Dibatalkan</p>
                        <p class="mt-2 text-3xl font-semibold text-slate-800">
                            {{ $queueStats['dibatalkan'] ?? 0 }}
                        </p>
                    </div>
                    <div class="rounded-lg bg-rose-50 border border-rose-100 p-2">
                        <svg class="w-5 h-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-3 text-xs text-slate-500">Antrian yang dibatalkan pada hari ini.</p>
            </div>
        </div>
    </section>

    {{-- SECTION 2: Audit Log / Riwayat Perubahan --}}
    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-slate-800">Audit Log</h3>
                <p class="text-sm text-slate-500">Riwayat perubahan pada entitas pendaftaran & pemeriksaan.</p>
            </div>
        </div>

        @php
        // Harapkan bentuk data array/collection berisi:
        // entity, changed_by, changed_at, detail
        $auditLogs = $auditLogs ?? [];
        @endphp

        <div class="rounded-xl bg-white shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr class="text-left">
                            <th class="px-4 py-3 font-semibold text-slate-700 w-16">No</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Entity</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Changed By</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Changed At</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Keterangan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($auditLogs as $i => $log)
                        @php
                        $entity = strtoupper($log['entity'] ?? $log->entity ?? '-');
                        $changedBy = $log['changed_by'] ?? $log->changed_by ?? '-';
                        $changedAt = $log['changed_at'] ?? $log->changed_at ?? '-';
                        $detail = $log['detail'] ?? $log->detail ?? '-';

                        // Badge entity
                        $badgeClass = 'bg-slate-100 text-slate-700 border-slate-200';
                        if (str_contains(strtolower($entity), 'pendaftaran')) $badgeClass = 'bg-indigo-50 text-indigo-700 border-indigo-200';
                        if (str_contains(strtolower($entity), 'pemeriksaan')) $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                        @endphp

                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-3 text-slate-600">
                                {{ is_int($i) ? $i + 1 : $loop->iteration }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg border text-xs font-semibold {{ $badgeClass }}">
                                    {{ $entity }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-700 font-medium">
                                {{ $changedBy }}
                            </td>
                            <td class="px-4 py-3 text-slate-600 tabular-nums">
                                {{ $changedAt }}
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $detail }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center">
                                <p class="text-sm font-semibold text-slate-700">Belum ada riwayat perubahan</p>
                                <p class="text-xs text-slate-500 mt-1">Audit log akan tampil ketika ada perubahan data.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="flex items-center justify-between px-4 py-3 border-t border-slate-200">
                    <div class="text-sm text-slate-500">
                        Halaman {{ $auditMeta['page'] }}
                    </div>

                    <div class="flex gap-2">
                        {{-- Prev --}}
                        @if($auditMeta['hasPrev'])
                        <a
                            href="{{ request()->fullUrlWithQuery(['page' => $auditMeta['page'] - 1]) }}"
                            class="px-3 py-1.5 rounded-lg border border-slate-300 text-sm hover:bg-slate-50">
                            ← Prev
                        </a>
                        @else
                        <span class="px-3 py-1.5 rounded-lg border border-slate-200 text-sm text-slate-400 cursor-not-allowed">
                            ← Prev
                        </span>
                        @endif

                        {{-- Next --}}
                        @if($auditMeta['hasNext'])
                        <a
                            href="{{ request()->fullUrlWithQuery(['page' => $auditMeta['page'] + 1]) }}"
                            class="px-3 py-1.5 rounded-lg border border-slate-300 text-sm hover:bg-slate-50">
                            Next →
                        </a>
                        @else
                        <span class="px-3 py-1.5 rounded-lg border border-slate-200 text-sm text-slate-400 cursor-not-allowed">
                            Next →
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

{{-- Realtime Clock Script (Alpine) --}}
<script>
    function realtimeClock() {
        return {
            nowText: '--',
            timer: null,

            formatNow() {
                // Format Indonesia: Senin, 22 Desember 2025 • 02:15:03
                try {
                    const now = new Date();
                    const date = new Intl.DateTimeFormat('id-ID', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: '2-digit',
                    }).format(now);

                    const time = new Intl.DateTimeFormat('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: false,
                    }).format(now);

                    this.nowText = `${date} • ${time}`;
                } catch (e) {
                    // fallback sederhana
                    const now = new Date();
                    this.nowText = now.toLocaleString();
                }
            },

            start() {
                this.formatNow();
                this.timer = setInterval(() => this.formatNow(), 1000);
            },
        }
    }
</script>
@endsection