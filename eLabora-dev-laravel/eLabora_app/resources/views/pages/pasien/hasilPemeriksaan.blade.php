@extends('layouts.app', ['sidebar' => 'pasien'])

@section('title', 'Hasil Pemeriksaan Pasien')

@section('content')
    <div class="px-6 py-6" x-data="{ filter: 'Semua' }">

        {{-- Judul --}}
        <h1 class="text-xl font-semibold mb-6">Hasil Pemeriksaan</h1>

        {{-- Search (optional, belum difungsikan) --}}
        <div class="mb-4">
            <input type="text" placeholder="Cari berdasarkan nomor lab"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

        {{-- Filter --}}
        <div class="flex gap-2 mb-6">
            <button @click="filter = 'Semua'"
                :class="filter === 'Semua' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700'"
                class="px-4 py-2 rounded-full text-sm">
                Semua
            </button>

            <button @click="filter = 'Patologi'"
                :class="filter === 'Patologi' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700'"
                class="px-4 py-2 rounded-full text-sm">
                Patologi
            </button>

            <button @click="filter = 'Anatomi'"
                :class="filter === 'Anatomi' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700'"
                class="px-4 py-2 rounded-full text-sm">
                Anatomi
            </button>

            <button @click="filter = 'Mikrobiologi'"
                :class="filter === 'Mikrobiologi' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700'"
                class="px-4 py-2 rounded-full text-sm">
                Mikrobiologi
            </button>
        </div>

        {{-- LIST --}}
        @if(empty($items) || count($items) === 0)
            <p class="text-gray-500">Hasil tidak ditemukan</p>
        @else
            <div class="space-y-4">
                @foreach ($items as $item)
                    <a x-show="filter === 'Semua' || filter === '{{ $item['kategori_nama'] ?? '' }}'"
                        href="{{ url('/detail-pemeriksaan/' . $item['pemeriksaan_id']) }}"
                        class="block bg-white rounded-xl border border-gray-200 p-4 hover:shadow transition">

                        <div class="flex items-center gap-4">

                            {{-- Icon --}}
                            <div class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center">
                                @if(($item['kategori_nama'] ?? '') === 'Patologi')
                                    <span class="text-indigo-600 text-xl">🧪</span>
                                @elseif(($item['kategori_nama'] ?? '') === 'Anatomi')
                                    <span class="text-indigo-600 text-xl">🧠</span>
                                @elseif(($item['kategori_nama'] ?? '') === 'Mikrobiologi')
                                    <span class="text-indigo-600 text-xl">🦠</span>
                                @else
                                    <span class="text-indigo-600 text-xl">📄</span>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">
                                    Pemeriksaan {{ $item['kategori_nama'] ?? '-' }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $item['tgl_pemeriksaan'] ?? '-' }}
                                </p>
                                <p class="text-sm text-gray-400">
                                    {{ $item['no_lab'] ?? '-' }}
                                </p>
                            </div>

                            {{-- Arrow --}}
                            <div class="text-gray-400 text-xl">›</div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

    </div>
@endsection