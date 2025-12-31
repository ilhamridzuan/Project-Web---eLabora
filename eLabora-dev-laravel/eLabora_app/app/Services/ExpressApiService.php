<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\UploadedFile;

class ExpressApiService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.express_api.url'), '/');
    }

    private function client(bool $auth = true): PendingRequest
    {
        $headers = ['Accept' => 'application/json'];

        if ($auth && session()->has('api_token')) {
            $headers['Authorization'] = 'Bearer ' . session('api_token');
        }

        return Http::withHeaders($headers);
    }

    public function login(string $username, string $password): Response
    {
        /** @var Response $response */
        $response = $this->client(false)->post("{$this->baseUrl}/auth/login", [
            'username' => $username,
            'password' => $password,
        ]);

        return $response;
    }

    public function registerPasien(array $payload): Response
    {
        /** @var Response $response */
        $response = $this->client(false)->post("{$this->baseUrl}/auth/register", $payload);

        return $response;
    }

    public function get(string $path, array $query = []): Response
    {
        /** @var Response $response */
        $response = $this->client(true)->get("{$this->baseUrl}{$path}", $query);

        return $response;
    }

    public function queueStats(): Response
    {
        /** @var Response $response */
        $response = $this->client(true)->get("{$this->baseUrl}/queue/stats");

        return $response;
    }

    public function auditLogs(array $params = []): Response
    {
        /** @var Response $response */
        $response = $this->client(true)->get("{$this->baseUrl}/audit-logs", $params);

        return $response;
    }

    public function queueToday()
    {
        /** @var Response $response */
        $response = $this->client(true)->get("{$this->baseUrl}/queue/today");
        return $response;
    }

    public function queueCall(int $id)
    {
        /** @var Response $response */
        $response = $this->client(true)->post("{$this->baseUrl}/queue/{$id}/call");
        return $response;
    }

    public function queueNext(int $id)
    {
        /** @var Response $response */
        $response = $this->client(true)->post("{$this->baseUrl}/queue/{$id}/next");
        return $response;
    }

    public function queueCancel(int $id)
    {
        /** @var Response $response */
        $response = $this->client(true)->post("{$this->baseUrl}/queue/{$id}/cancel");
        return $response;
    }

    public function examsList(array $params = [])
    {
        /** @var Response $response */
        $response = $this->client(true)->get("{$this->baseUrl}/exams/all", $params);
        return $response;
    }

    public function authMe(): Response
    {
        /** @var Response $response */
        $response = $this->client(true)->get("{$this->baseUrl}/auth/me");
        return $response;
    }

    // =========================
    // Registration (Pendaftaran)
    // =========================
    public function registrationCreate(array $payload, UploadedFile $suratRujukan): Response
    {
        /** @var Response $response */
        $response = $this->client(true)
            ->attach(
                'surat_rujukan', // harus sama persis dengan upload.single("surat_rujukan") di API
                file_get_contents($suratRujukan->getRealPath()),
                $suratRujukan->getClientOriginalName()
            )
            ->post("{$this->baseUrl}/registrations", $payload);

        return $response;
    }

    public function pasien(array $params = [])
    {
        /** @var Response $response */
        $response = $this->client(true)->get(
            "{$this->baseUrl}/patients",
            $params
        );
        return $response;
    }

    public function pasienDetail(int $id)
    {
        /** @var Response $response */
        $response = $this->client(true)->get(
            "{$this->baseUrl}/patients/{$id}"
        );
        return $response;   
    }

    // LIST HASIL PEMERIKSAAN
    public function listByPatient(int $pasienId): array
    {
        $response = $this->client()
            ->get("{$this->baseUrl}/exams/patients/{$pasienId}");

        if (!$response->successful()) {
            throw new \Exception('Gagal mengambil hasil pemeriksaan');
        }

        return $response->json('data');
    }

    public function detail(int $id): array
    {
        $response = $this->client()
            ->get("{$this->baseUrl}/exams/{$id}");

        if (!$response->successful()) {
            throw new \Exception('Detail pemeriksaan tidak ditemukan');
        }

        return $response->json();
    }
}