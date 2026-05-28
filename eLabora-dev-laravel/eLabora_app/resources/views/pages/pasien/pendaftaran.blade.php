@extends('layouts.app', ['sidebar' => 'pasien'])

@section('title', 'Pendaftaran Pasien')

@section('content')
    <div class="max-w-5xl mx-auto">

        {{-- Header with Tabs --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div class="flex items-center gap-4">
                <img src="{{ asset('assets/images/logo/Logo.png') }}" class="h-12">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">
                        Pendaftaran Pemeriksaan Laboratorium
                    </h1>
                    <p class="text-sm text-gray-500">
                        Sistem Pendaftaran Tes Lab Online
                    </p>
                </div>
            </div>

            {{-- Flowbite Button Group --}}
            <div class="inline-flex rounded-lg shadow-sm" role="group">
                <a href="{{ url('/pendaftaran') }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-indigo-600 rounded-s-lg hover:bg-indigo-700 focus:z-10 focus:ring-2 focus:ring-indigo-700">
                    Pendaftaran
                </a>
                <a href="{{ url('/antrian-pasien') }}" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-indigo-700 focus:z-10 focus:ring-2 focus:ring-indigo-700 focus:text-indigo-700">
                    Antrian
                </a>
            </div>
        </div>

        {{-- Flowbite Alerts --}}
        @if (session('success'))
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>{{ session('success') }}</div>
            </div>
        @endif
        @if (session('error'))
            <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Error</span>
                <div>{{ session('error') }}</div>
            </div>
        @endif
        @if ($errors->any())
            <div class="flex p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Errors</span>
                <div>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow">

            <h2 class="text-xl font-bold text-gray-900 mb-1">
                Form Pendaftaran Pemeriksaan Lab
            </h2>
            <p class="text-sm text-gray-500 mb-6">
                Isi formulir di bawah ini untuk mendaftar pemeriksaan laboratorium
            </p>

            <form class="space-y-6" method="POST" action="{{ route('pasien.pendaftaran.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Data Pasien --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Pasien</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Nama Lengkap --}}
                        <div>
                            <label for="nama" class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
                            <input type="text" id="nama" value="{{ data_get($profile, 'profil.nama') }}" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                        </div>

                        {{-- NIK --}}
                        <div>
                            <label for="nik" class="block mb-2 text-sm font-medium text-gray-900">NIK / No Identitas</label>
                            <input type="text" id="nik" value="{{ data_get($profile, 'profil.nik') }}" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div>
                            <label for="tgl_lahir" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Lahir</label>
                            <input type="date" id="tgl_lahir" value="{{ data_get($profile, 'profil.tgl_lahir') }}" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div>
                            <label for="jenis_kelamin" class="block mb-2 text-sm font-medium text-gray-900">Jenis Kelamin</label>
                            <select id="jenis_kelamin" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ data_get($profile, 'profil.jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ data_get($profile, 'profil.jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        {{-- No Telepon --}}
                        <div>
                            <label for="no_telepon" class="block mb-2 text-sm font-medium text-gray-900">No. Telepon</label>
                            <input type="text" id="no_telepon" value="{{ data_get($profile, 'profil.no_telepon') }}" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input type="email" id="email" value="{{ data_get($profile, 'akun.email') }}" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                        </div>

                        {{-- Surat Rujukan --}}
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="surat_rujukan">Surat Rujukan (PDF / JPG / PNG) <span class="text-gray-500 font-normal">(Opsional)</span></label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" id="surat_rujukan" name="surat_rujukan" type="file" accept=".pdf,.jpg,.jpeg,.png">
                            <p class="mt-1 text-xs text-gray-500">Maksimal 10MB. Format: PDF, JPG, PNG</p>
                        </div>

                        {{-- Alamat --}}
                        <div class="md:col-span-2">
                            <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900">Alamat</label>
                            <textarea id="alamat" rows="3" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">{{ data_get($profile, 'profil.alamat') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Jadwal Pemeriksaan --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Jadwal Pemeriksaan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Tanggal --}}
                        <div>
                            <label for="tanggal_antrian" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Pemeriksaan</label>
                            <input type="date" id="tanggal_antrian" name="tanggal_antrian" value="{{ old('tanggal_antrian', now()->toDateString()) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                        </div>

                        {{-- Jam --}}
                        <div>
                            <label for="jam_pemeriksaan" class="block mb-2 text-sm font-medium text-gray-900">Jam Pemeriksaan</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <input type="time" id="jam_pemeriksaan" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" min="08:00" max="17:00" value="09:00" required />
                            </div>
                        </div>

                        {{-- Hidden field --}}
                        <input type="hidden" name="jadwal_pemeriksaan_at" id="jadwal_pemeriksaan_at" value="{{ old('jadwal_pemeriksaan_at') }}">

                        <p class="text-xs text-gray-500 md:col-span-2">
                            Pilih jam pemeriksaan sesuai ketersediaan.
                        </p>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Daftar Sekarang
                </button>
            </form>
        </div>

    </div>

    <script>
        (function () {
            const tanggal = document.getElementById('tanggal_antrian');
            const jam = document.getElementById('jam_pemeriksaan');
            const hidden = document.getElementById('jadwal_pemeriksaan_at');

            function updateJadwal() {
                if (!tanggal.value || !jam.value) {
                    hidden.value = '';
                    return;
                }

                // format: YYYY-MM-DDTHH:mm
                hidden.value = `${tanggal.value}T${jam.value}`;
            }

            tanggal.addEventListener('change', updateJadwal);
            jam.addEventListener('change', updateJadwal);

            updateJadwal();
        })();
    </script>

@endsection
