<?php

namespace JeffersonGoncalves\CustomerIo;

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\CustomerIo\Exceptions\CustomerIoException;

/**
 * Thin wrapper around Laravel's Http client for the Customer.io App API
 * (https://api.customer.io/v1), authenticated with a Bearer app key.
 */
class CustomerIoAppClient
{
    public function __construct(
        protected string $appKey,
        protected string $baseUrl,
    ) {}

    /** @param array<string, mixed> $query */
    public function get(string $path, array $query = []): array
    {
        return $this->request('get', $path, $query);
    }

    /** @param array<string, mixed>|null $body */
    public function post(string $path, ?array $body = null): array
    {
        return $this->request('post', $path, $body);
    }

    /** @param array<string, mixed>|null $body */
    public function put(string $path, ?array $body = null): array
    {
        return $this->request('put', $path, $body);
    }

    public function delete(string $path): array
    {
        return $this->request('delete', $path);
    }

    /** @param array<string, mixed>|null $data */
    protected function request(string $method, string $path, ?array $data = null): array
    {
        $response = Http::withToken($this->appKey)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->baseUrl(rtrim($this->baseUrl, '/'))
            ->{$method}($path, $data ?? []);

        if ($response->failed()) {
            throw CustomerIoException::fromResponse($response);
        }

        return (array) ($response->json() ?? []);
    }
}
