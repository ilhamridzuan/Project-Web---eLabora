<?php

namespace App\Http\Controllers;

use App\Services\ExpressApiService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request, ExpressApiService $api)
    {
        // Sesuaikan dengan validator API: username + password min 6 :contentReference[oaicite:8]{index=8}
        $data = $request->validate([
            'username' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $resp = $api->login($data['username'], $data['password']);

        if (!$resp->successful()) {
            return back()
                ->withErrors(['username' => $resp->json('message') ?? 'Login gagal'])
                ->withInput();
        }

        // API kamu mengembalikan {token, role} :contentReference[oaicite:9]{index=9}
        $json = $resp->json();

        session([
            'api_token' => $json['token'] ?? null,
            'auth_role' => $json['role'] ?? null,
            'auth_username' => $data['username'],
        ]);

        $role = strtoupper((string) session('auth_role'));

        $map = [
            'PASIEN'  => '/dashboard-pasien',
            'PETUGAS' => '/dashboard-petugas',
            'ADMIN'   => '/dashboard-petugas', // kalau kamu anggap admin = petugas (sesuaikan)
        ];

        $routeName = $map[$role] ?? 'login';

        $request->session()->regenerate();

        return redirect()->to($routeName)->with('success', 'Login berhasil');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request, ExpressApiService $api)
    {
        // Sesuaikan dengan Joi registerPasienSchema :contentReference[oaicite:10]{index=10}
        $data = $request->validate([
            'username' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:120'],
            'password' => ['required', 'string', 'min:6'],

            'nik' => ['required', 'string', 'size:16'],
            'nama' => ['required', 'string', 'max:100'],
            'tgl_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
        ]);

        // API kamu menerima tgl_lahir format YYYY-MM-DD string :contentReference[oaicite:11]{index=11}
        if (!empty($data['tgl_lahir'])) {
            $data['tgl_lahir'] = date('Y-m-d', strtotime($data['tgl_lahir']));
        } else {
            $data['tgl_lahir'] = null;
        }

        $resp = $api->registerPasien($data);

        if (!$resp->successful()) {
            return back()
                ->withErrors(['username' => $resp->json('message') ?? 'Register gagal'])
                ->withInput();
        }

        // API kamu return {id, role, token} (auto-login) :contentReference[oaicite:12]{index=12}
        $json = $resp->json();

        session([
            'api_token' => $json['token'] ?? null,
            'auth_role' => $json['role'] ?? 'PASIEN',
            'auth_username' => $data['username'],
            'auth_akun_id' => $json['id'] ?? null,
        ]);

        $request->session()->regenerate();

        return redirect()->route('dashboard.pasien')->with('success', 'Register berhasil');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
