<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DummyJsonService
{
    protected $baseUrl = 'https://dummyjson.com/products';

    public function getProducts()
    {
        $response = Http::get($this->baseUrl);
        return $response->json()['products'] ?? [];
    }

    public function searchProducts(string $query)
    {
        $response = Http::get("{$this->baseUrl}/search", [
            'q' => $query,
        ]);
        return $response->json()['products'] ?? [];
    }

    public function getProduct($id)
    {
        $response = Http::get("{$this->baseUrl}/{$id}");
        return $response->json();
    }

    public function createProduct($data)
    {
        $response = Http::post("{$this->baseUrl}/add", $data);
        return $response->json();
    }

    public function updateProduct($id, $data)
    {
        $response = Http::put("{$this->baseUrl}/{$id}", $data);
        return $response->json();
    }

    public function deleteProduct($id)
    {
        $response = Http::delete("{$this->baseUrl}/{$id}");
        return $response->json();
    }
}