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
                <a href="{{ url('/antrian') }}" class="px-5 py-2 text-sm text-gray-600">
                    Antrian
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-8">
            <h2 class="text-xl font-semibold mb-1">
                Form Pendaftaran Pemeriksaan Lab
            </h2>
            <p class="text-sm text-gray-500 mb-6">
                Isi formulir di bawah ini untuk mendaftar pemeriksaan laboratorium
            </p>

            <form class="space-y-6">

                {{-- Data Pasien --}}
                <div>
                    <h3 class="font-semibold mb-3">Data Pasien</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" placeholder="Nama Lengkap *"
                            class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">

                        <input type="text" placeholder="NIK / No Identitas *"
                            class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">

                        <input type="date" class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">

                        <select class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">
                            <option>Jenis Kelamin</option>
                            <option>Laki-laki</option>
                            <option>Perempuan</option>
                        </select>

                        <input type="text" placeholder="No. Telepon *"
                            class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">

                        <input type="email" placeholder="Email"
                            class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Surat Rujukan (PDF / JPG / PNG)
                            </label>
                            <input type="file" name="surat_rujukan" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            <p class="text-xs text-gray-500 mt-1">
                                Maksimal 2MB. Format: PDF, JPG, PNG
                            </p>
                        </div>

                        <textarea rows="3" placeholder="Alamat"
                            class="md:col-span-2 border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400"></textarea>
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold mb-3">Jadwal Pemeriksaan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="date" class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">

                        <select class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400">
                            <option>Waktu Pemeriksaan</option>
                            <option>Pagi (08.00 - 11.00)</option>
                            <option>Siang (13.00 - 15.00)</option>
                        </select>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg font-semibold">
                    Daftar Sekarang
                </button>
            </form>
        </div>

    </div>
@endsection