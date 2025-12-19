@extends('layouts.app', ['sidebar' => 'pasien'])

@section('title', 'Hasil Pemeriksaan')

@section('content')
<body class="bg-[#f6f8fc] ml-[260px] min-h-screen">

    <div class="p-8">

        {{-- Search --}}
        <div class="mb-6">
            <input
                type="text"
                placeholder="Cari berdasarkan nomor lab"
                class="w-full px-4 py-3 mb-4 border border-[#dce1f2] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white"
                disabled
            >

            {{-- Filter --}}
            <div class="flex flex-wrap gap-3">
                <button class="px-6 py-2 rounded-xl bg-indigo-600 text-white text-sm shadow" disabled>
                    Semua
                </button>
                <button class="px-6 py-2 rounded-xl bg-[#eef1f8] text-sm" disabled>
                    Patologi
                </button>
                <button class="px-6 py-2 rounded-xl bg-[#eef1f8] text-sm" disabled>
                    Anatomi
                </button>
                <button class="px-6 py-2 rounded-xl bg-[#eef1f8] text-sm" disabled>
                    Mikrobiologi
                </button>
            </div>
        </div>
    </div>

</body>
@endsection
