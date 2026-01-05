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
        // username + password
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

        $json = $resp->json();

        session([
            'api_token' => $json['token'] ?? null,
            'auth_role' => $json['role'] ?? null,
            'auth_username' => $data['username'],
        ]);

        $role = strtoupper((string) session('auth_role'));

        $map = [
            'PASIEN'  => '/dashboard-pasien',
            'DOKTER'  => '/dashboard-dokter',
            'PETUGAS' => '/dashboard-petugas',
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
        $data = $request->validate([
            'username' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:120'],
            'password' => ['required', 'string', 'min:6'],
            'nik' => ['required', 'string', 'size:16'],
            'nama' => ['required', 'string', 'max:100'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tgl_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
        ]);

        // API menerima tgl_lahir format YYYY-MM-DD
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

        $json = $resp->json();

        session([
            'api_token' => $json['token'] ?? null,
            'auth_role' => $json['role'] ?? 'PASIEN',
            'auth_username' => $data['username'],
            'auth_akun_id' => $json['id'] ?? null,
        ]);

        $request->session()->regenerate();

        return redirect()->route('pasien.dashboard')->with('success', 'Register berhasil');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
