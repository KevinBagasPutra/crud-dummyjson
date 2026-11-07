<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class DummyJsonService
{
    protected function client(): PendingRequest
    {
        return Http::baseUrl(config('services.dummyjson.url'))
            ->acceptJson()
            ->timeout(15);
    }

    public function all(int $limit = 10, int $skip = 0): array
    {
        return $this->client()
            ->get('/products', ['limit' => $limit, 'skip' => $skip])
            ->throw()->json();
    }

    public function find(int $id): array
    {
        return $this->client()->get("/products/{$id}")->throw()->json();
    }

    public function create(array $data): array
    {
        return $this->client()->post('/products/add', $data)->throw()->json();
    }

    public function update(int $id, array $data): array
    {
        return $this->client()->put("/products/{$id}", $data)->throw()->json();
    }

    public function delete(int $id): array
    {
        return $this->client()->delete("/products/{$id}")->throw()->json();
    }
}