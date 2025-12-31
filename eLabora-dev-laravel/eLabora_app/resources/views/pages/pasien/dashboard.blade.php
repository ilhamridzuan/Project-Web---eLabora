@extends('layouts.app', ['sidebar' => 'pasien'])

@section('title', 'Beranda Pasien')

@section('content')
<div class="space-y-8">

    {{-- Header --}}
    <div>
        <h2 class="text-2xl font-semibold text-slate-800">Beranda</h2>
    </div>

    {{-- Carousel --}}
    <div
        x-data="carousel()"
        x-init="start()"
        class="relative w-full h-[260px] rounded-xl overflow-hidden bg-indigo-600 shadow-sm">
        {{-- Slides --}}
        <template x-for="(slide, index) in slides" :key="index">
            <img
                :src="slide"
                x-show="active === index"
                x-transition.opacity.duration.500ms
                class="absolute inset-0 w-full h-full object-contain" />
        </template>

        {{-- Prev --}}
        <button
            @click="prev"
            class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white shadow flex items-center justify-center">
            ‹
        </button>

        {{-- Next --}}
        <button
            @click="next"
            class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white shadow flex items-center justify-center">
            ›
        </button>
    </div>

    {{-- Menu Cards --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ url('/pendaftaran') }}"
            class="group flex items-center gap-5 bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition relative">
            <img src="{{ asset('assets/images/icons/lucide_clipboard-pen-line.png') }}" class="w-8 h-8">
            <h3 class="text-base font-medium text-slate-700">Pendaftaran</h3>
            <span class="absolute right-6 text-3xl text-indigo-400 group-hover:translate-x-1 transition">›</span>
        </a>

        <a href="{{ url('/hasil-pemeriksaan') }}"
            class="group flex items-center gap-5 bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition relative">
            <img src="{{ asset('assets/images/icons/tabler_microscope.png') }}" class="w-8 h-8">
            <h3 class="text-base font-medium text-slate-700">Cek Hasil Pemeriksaan</h3>
            <span class="absolute right-6 text-3xl text-indigo-400 group-hover:translate-x-1 transition">›</span>
        </a>

        <a href="{{ url('/riwayat') }}"
            class="group flex items-center gap-5 bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition relative">
            <img src="{{ asset('assets/images/icons/material-symbols-light_history-rounded.png') }}" class="w-8 h-8">
            <h3 class="text-base font-medium text-slate-700">Riwayat Pemeriksaan</h3>
            <span class="absolute right-6 text-3xl text-indigo-400 group-hover:translate-x-1 transition">›</span>
        </a>
    </section>

    {{-- Queue Section --}}
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Tabel Antrian --}}
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h3 class="text-lg font-semibold text-slate-800">Daftar Antrian Laboratorium Hari Ini</h3>
                    <p class="text-sm text-slate-500">Update otomatis sesuai data sistem.</p>
                </div>
            </div>

            <div class="rounded-xl bg-white shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-center">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3 font-semibold text-slate-700">No. Antrian</th>
                                <th class="px-4 py-3 font-semibold text-slate-700">Jenis Pemeriksaan</th>
                                <th class="px-4 py-3 font-semibold text-slate-700">Status</th>
                                <th class="px-4 py-3 font-semibold text-slate-700">Waktu</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse($queues ?? [] as $q)
                            @php
                            $status = strtoupper($q['status'] ?? '-');

                            // badge warna (tetap seperti sebelumnya)
                            $badge = 'bg-slate-100 text-slate-700 border-slate-200';
                            if ($status === 'MENUNGGU' || $status === 'PENDING') $badge = 'bg-amber-50 text-amber-700 border-amber-200';
                            elseif ($status === 'DILAYANI' || $status === 'PROSES') $badge = 'bg-indigo-50 text-indigo-700 border-indigo-200';
                            elseif ($status === 'SELESAI' || $status === 'DONE') $badge = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                            elseif ($status === 'DIBATALKAN' || $status === 'BATAL' || $status === 'CANCEL') $badge = 'bg-rose-50 text-rose-700 border-rose-200';

                            // isi tetap (tidak mengubah struktur data kamu)
                            $jenis = $q['kategori_nama'] ?? $q['kategori'] ?? $q['no_lab'] ?? '-';

                            $waktu = '-';
                            if (!empty($q['jadwal_pemeriksaan_at'])) {
                            try {
                            $waktu = \Carbon\Carbon::parse($q['jadwal_pemeriksaan_at'])->format('H:i');
                            } catch (\Throwable $e) {}
                            }
                            @endphp

                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-3 text-slate-800 font-semibold tabular-nums">
                                    {{ $q['no_antrian'] ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-slate-700">
                                    {{ $jenis }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg border text-xs font-semibold {{ $badge }}">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-slate-600 tabular-nums">
                                    {{ $waktu }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-10 text-center">
                                    <p class="text-sm font-semibold text-slate-700">Belum ada antrian hari ini</p>
                                    <p class="text-xs text-slate-500 mt-1">Data antrian akan tampil ketika ada pendaftaran.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        {{-- Info Antrian Saat Ini --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col">
            <h3 class="font-semibold text-slate-800 text-center mb-5">
                Informasi Antrian Saat Ini
            </h3>

            @if(!empty($current))
            <div class="flex-1">
                <div
                    class="rounded-xl p-5 border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white">

                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs text-slate-500">No Antrian</p>
                            <p class="mt-1 text-3xl font-semibold text-indigo-700 tracking-tight tabular-nums">
                                {{ $current['no_antrian'] ?? '-' }}
                            </p>
                        </div>

                        @php
                        $stNow = strtoupper($current['status'] ?? 'DILAYANI');
                        @endphp
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-lg border text-xs font-semibold
                               bg-indigo-50 text-indigo-700 border-indigo-200">
                            {{ $stNow }}
                        </span>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                        <div class="rounded-lg bg-white border border-slate-200 p-3">
                            <p class="text-xs text-slate-500">No Lab</p>
                            <p class="mt-1 font-medium text-slate-800">
                                {{ $current['no_lab'] ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-white border border-slate-200 p-3 text-right">
                            <p class="text-xs text-slate-500">Jadwal</p>
                            <p class="mt-1 font-medium text-slate-800">
                                @if(!empty($current['jadwal_pemeriksaan_at']))
                                {{ \Carbon\Carbon::parse($current['jadwal_pemeriksaan_at'])->format('d M Y, H:i') }}
                                @else
                                -
                                @endif
                            </p>

                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="flex-1 flex items-center justify-center text-slate-400">
                Belum ada pasien
            </div>
            @endif
        </div>

    </section>

</div>
<script>
    function carousel() {
        return {
            active: 0,

            slides: [
                "{{ asset('assets/images/sliders/slides1.png') }}",
                "{{ asset('assets/images/sliders/slides2.png') }}",
                "{{ asset('assets/images/sliders/slides3.png') }}",
            ],

            start() {
                setInterval(() => {
                    this.next()
                }, 5000)
            },

            next() {
                this.active = (this.active + 1) % this.slides.length
            },

            prev() {
                this.active =
                    (this.active - 1 + this.slides.length) % this.slides.length
            }
        }
    }
</script>
@endsection