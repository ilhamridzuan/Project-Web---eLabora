<header class="fixed top-0 left-0 right-0 z-50 h-[60px] bg-white flex items-center justify-between px-6 shadow-sm">
    {{-- Logo --}}
    <div class="flex items-center">
        <img src="{{ asset('assets/images/logo/Logo.png') }}" alt="Logo elabora" class="h-[42px] w-auto" />
    </div>

    {{-- Search --}}
    <div class="w-full max-w-[400px] mx-6">
        <div class="flex items-center px-3 py-2 rounded-md border border-slate-300 bg-slate-50">
            <input
                type="text"
                placeholder="Search"
                class="w-full bg-transparent outline-none text-sm text-slate-500 placeholder:text-slate-400" />
        </div>
    </div>

    {{-- Profile + Logout --}}
    <div class="flex items-center gap-3">
        {{-- Profile picture --}}
        <img
            src="{{ asset('assets/img/profilepict.jpg') }}"
            alt="profile-picture"
            class="w-10 h-10 rounded-full border-2 border-indigo-600 object-cover" />

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="px-3 py-1.5 text-sm rounded-md bg-indigo-600 text-white
                       hover:bg-indigo-700 transition">
                Logout
            </button>
        </form>
    </div>
</header>