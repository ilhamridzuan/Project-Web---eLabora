<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | eLabora</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-sm p-8">
        <div class="text-center mb-6">
            <img src="{{ asset('assets/images/logo/Logo.png') }}" alt="eLabora" class="h-12 mx-auto mb-3">
            <h1 class="text-2xl font-bold">Login eLabora</h1>
            <p class="text-sm text-slate-600 mt-1">
                Masuk untuk melanjutkan ke sistem laboratorium
            </p>
        </div>

        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700">
                    Username
                </label>
                <input type="text" name="username" value="{{ old('username') }}" required
                    class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2 text-sm
                           focus:outline-none focus:ring-2 focus:ring-indigo-400">
                           @error('username') <p class="text-sm text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">
                    Password
                </label>
                <input type="password" name="password" required
                    class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2 text-sm
                           focus:outline-none focus:ring-2 focus:ring-indigo-400">
                           @error('password') <p class="text-sm text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" 
                class="w-full bg-indigo-600 text-white rounded-xl py-2 font-semibold hover:bg-indigo-700 transition">
                Masuk
            </button>
        </form>

        <p class="text-center text-sm text-slate-600 mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-indigo-700 hover:underline">
                Daftar di sini
            </a>
        </p>
    </div>

</body>
</html>
