<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register | eLabora</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center py-10">

    <div class="w-full max-w-xl bg-white rounded-2xl shadow-sm p-8">
        <div class="text-center mb-6">
            <img src="{{ asset('assets/images/logo/Logo.png') }}" alt="eLabora" class="h-12 mx-auto mb-3">
            <h1 class="text-2xl font-bold">Registrasi Pasien</h1>
            <p class="text-sm text-slate-600 mt-1">
                Buat akun untuk melakukan pendaftaran pemeriksaan
            </p>
        </div>

        <form method="POST" action="{{ route('register.post') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Username</label>
                    <input type="text" name="username" required
                        class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="email" required
                        class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Password</label>
                <input type="password" name="password" required
                    class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2 text-sm">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">NIK</label>
                    <input type="text" name="nik" required
                        class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
                    <input type="text" name="nama" required
                        class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2 text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir"
                        class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">No. Telepon</label>
                    <input type="text" name="no_telepon"
                        class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Alamat</label>
                <textarea name="alamat" rows="2"
                    class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2 text-sm"></textarea>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white rounded-xl py-2 font-semibold hover:bg-indigo-700 transition">
                Daftar Akun
            </button>
        </form>

        <p class="text-center text-sm text-slate-600 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-indigo-700 hover:underline">
                Login
            </a>
        </p>
    </div>

</body>
</html>
