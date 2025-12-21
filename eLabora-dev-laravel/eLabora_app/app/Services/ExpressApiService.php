<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

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
}
