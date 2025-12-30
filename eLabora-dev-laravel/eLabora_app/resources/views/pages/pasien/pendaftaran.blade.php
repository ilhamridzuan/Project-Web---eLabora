@extends('layouts.app', ['sidebar' => 'pasien'])

@section('title', 'Pendaftaran Pasien')

@section('content')
    <div class="max-w-5xl mx-auto">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div class="flex items-center gap-4">
                <img src="{{ asset('assets/images/logo/Logo.png') }}" class="h-12">
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">
                        Pendaftaran Pemeriksaan Laboratorium
                    </h1>
                    <p class="text-sm text-gray-500">
                        Sistem Pendaftaran Tes Lab Online
                    </p>
                </div>
            </div>

            <div class="flex bg-gray-200 rounded-full p-1">
                <a href="{{ url('/pendaftaran') }}"
                    class="px-5 py-2 text-sm font-medium bg-white rounded-full shadow">
                    Pendaftaran
                </a>
                <a href="{{ url('/antrian-pasien') }}" class="px-5 py-2 text-sm text-gray-600">
                    Antrian
                </a>
            </div>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow p-8">

            <h2 class="text-xl font-semibold mb-1">
                Form Pendaftaran Pemeriksaan Lab
            </h2>
            <p class="text-sm text-gray-500 mb-6">
                Isi formulir di bawah ini untuk mendaftar pemeriksaan laboratorium
            </p>

            <form class="space-y-6" method="POST" action="{{ route('pasien.pendaftaran.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Data Pasien --}}
                <div>
                    <h3 class="font-semibold mb-3">Data Pasien</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" placeholder="Nama Lengkap *"
                            value="{{ data_get($profile, 'profil.nama') }}" readonly
                            class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">

                        <input type="text" placeholder="NIK / No Identitas *"
                            value="{{ data_get($profile, 'profil.nik') }}" readonly
                            class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">

                        <input type="date"
                            value="{{ data_get($profile, 'profil.tgl_lahir') }}" readonly
                            class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">

                        <select class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400" disabled>
                            <option>Jenis Kelamin</option>
                            <option {{ data_get($profile, 'profil.jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option {{ data_get($profile, 'profil.jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>

                        <input type="text" placeholder="No. Telepon *"
                            value="{{ data_get($profile, 'profil.no_telepon') }}" readonly
                            class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">

                        <input type="email" placeholder="Email"
                            value="{{ data_get($profile, 'akun.email') }}" readonly
                            class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Surat Rujukan (PDF / JPG / PNG)
                            </label>
                            <input type="file" name="surat_rujukan" required accept=".pdf,.jpg,.jpeg,.png"
                                class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            <p class="text-xs text-gray-500 mt-1">
                                Maksimal 10MB. Format: PDF, JPG, PNG
                            </p>
                        </div>

                        <textarea rows="3" placeholder="Alamat" readonly
                            class="md:col-span-2 border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">{{ data_get($profile, 'profil.alamat') }}</textarea>
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold mb-3">Jadwal Pemeriksaan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="date"
                            name="tanggal_antrian"
                            id="tanggal_antrian"
                            value="{{ old('tanggal_antrian', now()->toDateString()) }}"
                            class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400"
                            required>

                        <input type="time"
                            id="jam_pemeriksaan"
                            class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400"
                            required>

                        {{-- Hidden field yang dikirim ke API --}}
                        <input type="hidden"
                            name="jadwal_pemeriksaan_at"
                            id="jadwal_pemeriksaan_at"
                            value="{{ old('jadwal_pemeriksaan_at') }}">

                        <p class="text-xs text-gray-500 md:col-span-2">
                            Pilih jam pemeriksaan sesuai ketersediaan.
                        </p>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg font-semibold">
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
