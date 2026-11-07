<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = is_array($this->resource) ? $this->resource : (array) $this->resource;

        return [
            'id'                  => $data['id'] ?? null,
            'title'               => $data['title'] ?? null,
            'description'         => $data['description'] ?? null,
            'category'            => $data['category'] ?? null,
            'price'               => isset($data['price']) ? (float) $data['price'] : null,
            'discount_percentage' => $data['discountPercentage'] ?? null,
            'rating'              => $data['rating'] ?? null,
            'stock'               => $data['stock'] ?? null,
            'brand'               => $data['brand'] ?? null,
            'thumbnail'           => $data['thumbnail'] ?? null,
            'images'              => $data['images'] ?? [],
            'is_deleted'          => $data['isDeleted'] ?? false,
            'deleted_on'          => $data['deletedOn'] ?? null,
        ];
    }
}