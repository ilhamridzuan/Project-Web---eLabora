@extends('layouts.app', ['sidebar' => 'pasien'])

@section('title', 'Detail Hasil Pemeriksaan Pasien')

@section('content')
    <div class="px-6 py-6 max-w-3xl">

        {{-- Back --}}
        <a href="{{ url('/hasil-pemeriksaan') }}"
            class="inline-block mb-4 px-4 py-2 rounded-lg border border-gray-300 text-sm">
            Kembali
        </a>

        {{-- Card --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">

            <h2 class="text-lg font-semibold mb-6">Detail Pemeriksaan</h2>

            {{-- FORM-LIKE LAYOUT --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-y-5">

                {{-- Nama Pasien --}}
                <p class="text-sm text-gray-500">Nama Pasien</p>
                <p class="md:col-span-2 font-medium">
                    {{ $data['pasien_nama'] ?? '-' }}
                </p>

                {{-- Jenis Pemeriksaan --}}
                <p class="text-sm text-gray-500">Jenis Pemeriksaan</p>
                <p class="md:col-span-2 font-medium">
                    Pemeriksaan {{ $data['kategori_nama'] ?? '-' }}
                </p>

                {{-- Kategori --}}
                <p class="text-sm text-gray-500">Kategori</p>
                <div class="md:col-span-2">
                    <span class="inline-block px-3 py-1 rounded-full bg-indigo-100 text-indigo-600 text-sm">
                        {{ $data['kategori_nama'] ?? '-' }}
                    </span>
                </div>

                {{-- Status --}}
                <p class="text-sm text-gray-500">Status</p>
                <div class="md:col-span-2">
                    <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-600 text-sm">
                        {{ $data['status_hasil'] ?? '-' }}
                    </span>
                </div>

                {{-- Tanggal --}}
                <p class="text-sm text-gray-500">Tanggal & Waktu</p>
                <p class="md:col-span-2 font-medium">
                    {{ $data['tgl_pemeriksaan'] ?? '-' }}
                </p>

                {{-- No Lab --}}
                <p class="text-sm text-gray-500">No. Laboratorium</p>
                <p class="md:col-span-2 font-medium">
                    {{ $data['no_lab'] ?? '-' }}
                </p>

            </div>
        </div>

        {{-- FILE HASIL --}}
        <div class="mt-6">
            <h3 class="font-semibold mb-2">File Hasil Pemeriksaan</h3>

            @if(!empty($data['files']) && count($data['files']) > 0)
                <div class="space-y-2">
                    @foreach ($data['files'] as $file)
                        <a href="{{ config('services.express_api.url') . $file['file_path'] }}" target="_blank"
                            class="flex justify-between items-center bg-white border rounded-lg px-4 py-3 hover:bg-gray-50">

                            <span class="text-sm text-gray-700">
                                {{ basename($file['file_path']) }}
                            </span>

                            <span class="text-indigo-600 text-sm font-medium">
                                Download
                            </span>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">Belum ada file hasil pemeriksaan.</p>
            @endif
        </div>

    </div>
@endsection