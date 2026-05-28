@extends('layouts.app', ['sidebar' => 'pasien'])

@section('title', 'Detail Hasil Pemeriksaan Pasien')

@section('content')
    <div class="px-6 py-6 max-w-3xl">

        {{-- Flowbite Back Button --}}
        <a href="{{ url('/hasil-pemeriksaan') }}" class="inline-flex items-center px-4 py-2 mb-4 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-100">
            <svg class="w-3 h-3 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
            </svg>
            Kembali
        </a>

        {{-- Flowbite Card --}}
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow">

            <h2 class="text-xl font-bold text-gray-900 mb-6">Detail Pemeriksaan</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-y-5">

                <p class="text-sm font-medium text-gray-500">Nama Pasien</p>
                <p class="md:col-span-2 text-gray-900">
                    {{ $data['pasien_nama'] ?? '-' }}
                </p>

                <p class="text-sm font-medium text-gray-500">Jenis Pemeriksaan</p>
                <p class="md:col-span-2 text-gray-900">
                    Pemeriksaan {{ $data['kategori_nama'] ?? '-' }}
                </p>

                <p class="text-sm font-medium text-gray-500">Kategori</p>
                <div class="md:col-span-2">
                    <span class="bg-primary-100 text-primary-800 text-xs font-medium px-2.5 py-0.5 rounded">
                        {{ $data['kategori_nama'] ?? '-' }}
                    </span>
                </div>

                <p class="text-sm font-medium text-gray-500">Status</p>
                <div class="md:col-span-2">
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">
                        {{ str_replace('_', ' ', $data['status_hasil'] ?? '-') }}
                    </span>
                </div>

                <p class="text-sm font-medium text-gray-500">Tanggal & Waktu</p>
                <p class="md:col-span-2 text-gray-900">
                    @if(!empty($data['tgl_pemeriksaan']))
                        {{ \Carbon\Carbon::parse($data['tgl_pemeriksaan'])->translatedFormat('d M Y, H:i') }}
                    @else
                        -
                    @endif
                </p>

                <p class="text-sm font-medium text-gray-500">No. Laboratorium</p>
                <p class="md:col-span-2 text-gray-900">
                    {{ $data['no_lab'] ?? '-' }}
                </p>

            </div>
        </div>

        {{-- File Downloads Section --}}
        <div class="mt-6">
            <h3 class="text-lg font-bold text-gray-900 mb-3">File Hasil Pemeriksaan</h3>

            @if(!empty($data['files']) && count($data['files']) > 0)
                <div class="space-y-2">
                    @foreach ($data['files'] as $file)
                        <a href="{{ config('services.express_api.url') . $file['file_path'] }}" target="_blank" class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-lg hover:bg-gray-100">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/>
                                    <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                                </svg>
                                <span class="text-sm text-gray-700">
                                    {{ basename($file['file_path']) }}
                                </span>
                            </div>

                            <span class="inline-flex items-center text-sm font-medium text-primary-600 hover:underline">
                                Download
                                <svg class="w-3 h-3 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                            </span>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="flex items-center p-4 text-sm text-gray-800 border border-gray-300 rounded-lg bg-gray-50" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>Belum ada file hasil pemeriksaan.</div>
                </div>
            @endif
        </div>

    </div>
@endsection