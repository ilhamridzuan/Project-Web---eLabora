@php
    $items = [
        ['label' => 'Beranda', 'url' => url('/dashboard-pasien')],
        ['label' => 'Pendaftaran', 'url' => url('/pendaftaran')],
        ['label' => 'Cek Hasil Pemeriksaan', 'url' => url('/hasilPemeriksaan')],
        ['label' => 'Riwayat Pemeriksaan', 'url' => url('/riwayat')],
    ];

    $currentUrl = url()->current();
@endphp

<aside class="fixed left-0 top-[60px] bottom-0 w-[240px] bg-white flex flex-col justify-between py-4">
    {{-- Menu --}}
    <nav class="px-3 flex flex-col gap-1">
        @foreach ($items as $item)
            @php
                $isActive = $currentUrl === $item['url'];
            @endphp

            <a
                href="{{ $item['url'] }}"
                class="flex items-center px-3 py-2 rounded-lg text-[15px] transition
                    {{ $isActive ? 'bg-indigo-50 text-indigo-600' : 'text-slate-500 hover:bg-indigo-50 hover:text-slate-700' }}"
            >
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    {{-- Footer --}}
    <div class="flex items-center gap-3 px-4 py-3">
        <img
            src="{{ asset('assets/img/profilepict.jpg') }}"
            alt="profile-picture"
            class="w-9 h-9 rounded-full object-cover cursor-pointer"
        />
        <span class="text-sm font-medium text-slate-700">
            {{-- Kalau sudah pakai auth, ganti jadi auth()->user()->name --}}
            Muhammad Soekarno
        </span>
    </div>
</aside>
