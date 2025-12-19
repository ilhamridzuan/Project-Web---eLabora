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
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6">
        <h3 class="font-semibold text-slate-800 mb-4">
            Daftar Antrian Laboratorium Hari Ini
        </h3>

        <table class="w-full text-sm text-center border-collapse">
            <thead class="bg-indigo-50 text-indigo-700">
                <tr>
                    <th class="py-2">No. Antrian</th>
                    <th>Jenis Pemeriksaan</th>
                    <th>Status</th>
                    <th>Waktu</th>
                </tr>
            </thead>

            <tbody class="text-slate-600">
                <tr class="border-b">
                    <td class="py-2">A001</td>
                    <td>Patologi</td>
                    <td>
                        <span class="px-3 py-1 rounded-full bg-indigo-600 text-white text-xs">
                            Sedang Dilayani
                        </span>
                    </td>
                    <td>08:30</td>
                </tr>

                <tr class="border-b">
                    <td class="py-2">A002</td>
                    <td>Anatomi</td>
                    <td>
                        <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs">
                            Menunggu
                        </span>
                    </td>
                    <td>08:45</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Info Antrian Saat Ini --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 space-y-4">
        <h3 class="font-semibold text-center text-slate-800">
            Informasi Antrian Saat Ini
        </h3>

        {{-- Nomor Antrian Saat Ini --}}
        <div class="text-center">
            <p class="text-sm text-slate-500">Nomor Antrian</p>
            <p class="text-3xl font-semibold text-indigo-600">A004</p>
        </div>

        {{-- Ringkasan --}}
        <div class="grid grid-cols-1 gap-3 text-sm">
            <div class="rounded-xl bg-indigo-50 border border-indigo-100 p-4">
                <p class="text-xs text-slate-500">Jenis Pemeriksaan</p>
                <p class="font-medium text-slate-800">Anatomi</p>
            </div>

            <div class="rounded-xl bg-indigo-50 border border-indigo-100 p-4">
                <p class="text-xs text-slate-500">Estimasi Waktu Tunggu</p>
                <p class="font-medium text-slate-800">± 60 menit</p>
            </div>

            <div class="rounded-xl bg-indigo-50 border border-indigo-100 p-4">
                <p class="text-xs text-slate-500">Lokasi Ruang</p>
                <p class="font-medium text-slate-800">Ruang B</p>
            </div>
        </div>

        {{-- Antrian Sebelumnya & Selanjutnya --}}
        <div class="grid grid-cols-2 gap-3 pt-2">
            <div class="rounded-xl border border-slate-200 p-4 text-center">
                <p class="text-xs text-slate-500">Antrian Sebelumnya</p>
                <p class="mt-1 font-semibold text-slate-800">A003</p>
            </div>
            <div class="rounded-xl border border-slate-200 p-4 text-center">
                <p class="text-xs text-slate-500">Antrian Selanjutnya</p>
                <p class="mt-1 font-semibold text-slate-800">A005</p>
            </div>
        </div>
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