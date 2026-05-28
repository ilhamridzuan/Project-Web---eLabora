<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 lg:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white flex flex-col">
        <ul class="space-y-2 font-medium flex-1">
            @php
            $items = [
                ['label' => 'Beranda', 'url' => url('/dashboard-pasien'), 'icon' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>'],
                ['label' => 'Pendaftaran', 'url' => url('/pendaftaran'), 'icon' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>'],
                ['label' => 'Cek Hasil Pemeriksaan', 'url' => url('/hasil-pemeriksaan'), 'icon' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>'],
                ['label' => 'Riwayat Pemeriksaan', 'url' => url('/riwayat'), 'icon' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>'],
            ];
            $currentUrl = url()->current();
            @endphp

            @foreach ($items as $item)
            @php
            $isActive = $currentUrl === $item['url'];
            @endphp
            <li>
                <a href="{{ $item['url'] }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-indigo-50 group {{ $isActive ? 'bg-indigo-100' : '' }}">
                    <span class="{{ $isActive ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }}">
                        {!! $item['icon'] !!}
                    </span>
                    <span class="ms-3 {{ $isActive ? 'text-indigo-600 font-semibold' : '' }}">{{ $item['label'] }}</span>
                </a>
            </li>
            @endforeach
        </ul>

        {{-- User Profile Card with Dropdown --}}
        <div class="pt-4 mt-4 border-t border-gray-200">
            <button type="button" class="flex items-center w-full p-3 text-left rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" data-dropdown-toggle="sidebar-user-dropdown" data-dropdown-placement="top">
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-600 text-white font-semibold">
                    {{ strtoupper(substr(session('auth_username') ?? 'G', 0, 1)) }}
                </div>
                <div class="flex-1 ms-3 text-left">
                    <p class="text-sm font-medium text-gray-900">
                        {{ session('auth_username') ?? 'Guest' }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ session('auth_role') ?? '' }}
                    </p>
                </div>
                <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>

            {{-- Dropdown Menu --}}
            <div id="sidebar-user-dropdown" class="z-50 hidden my-2 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow">
                <ul class="py-2" role="none">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                <svg class="w-4 h-4 me-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</aside>