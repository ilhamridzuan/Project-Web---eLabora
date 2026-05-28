@extends('layouts.app', ['sidebar' => 'dokter'])

@section('title', 'Hasil Pemeriksaan Pasien')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Hasil Pemeriksaan</h2>
            <p class="mt-1 text-sm text-gray-500">
                @if($pasienName)
                Pasien: <span class="font-semibold text-gray-900">{{ $pasienName }}</span>
                @else
                ID Pasien: <span class="font-semibold text-gray-900">{{ $pasienId }}</span>
                @endif
            </p>
        </div>

        <a href="{{ route('pasien.dokter') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-100">
            <svg class="w-3 h-3 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Flowbite Alert --}}
    @if($errorMessage)
    <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Error</span>
        <div>{{ $errorMessage }}</div>
    </div>
    @endif

    {{-- Flowbite Table --}}
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center">No</th>
                    <th scope="col" class="px-6 py-3 text-center">ID Pemeriksaan</th>
                    <th scope="col" class="px-6 py-3 text-center">ID Pendaftaran</th>
                    <th scope="col" class="px-6 py-3">Kategori</th>
                    <th scope="col" class="px-6 py-3 text-center">Tgl Pemeriksaan</th>
                    <th scope="col" class="px-6 py-3">Catatan</th>
                    <th scope="col" class="px-6 py-3 text-center">Hasil</th>
                </tr>
            </thead>
            <tbody>
                @forelse($exams as $exam)
                @php
                $examId = $exam['pemeriksaan_id'] ?? $exam['id'] ?? '-';
                $fileUrl = $exam['file_url'] ?? $exam['file'] ?? null;
                @endphp

                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 text-center text-gray-900">
                        {{ $loop->iteration }}
                    </td>

                    <td class="px-6 py-4 text-center font-medium text-gray-900">
                        {{ $examId }}
                    </td>

                    <td class="px-6 py-4 text-center text-gray-900">
                        {{ $exam['pendaftaran_id'] ?? '-' }}
                    </td>

                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $exam['kategori_nama'] ?? '-' }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        {{ $exam['tgl_pemeriksaan'] ?? '-' }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="line-clamp-2">
                            {{ $exam['catatan'] ?? '-' }}
                        </div>
                    </td>

                    <td class="px-6 py-4 text-center">
                        @php
                        $downloadUrl = $exam['download_url'] ?? null;
                        @endphp

                        @if($downloadUrl)
                        <a href="{{ $downloadUrl }}" target="_blank" class="inline-flex items-center font-medium text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg text-xs px-3 py-2">
                            <svg class="w-3 h-3 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/>
                                <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                            </svg>
                            Download
                        </a>
                        @else
                        <span class="text-xs text-gray-400">Tidak ada file</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-10 text-center">
                        <p class="text-sm font-semibold text-gray-700">
                            Belum ada hasil pemeriksaan
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            Hanya pemeriksaan dengan status HASIL_TERSEDIA yang ditampilkan.
                        </p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection