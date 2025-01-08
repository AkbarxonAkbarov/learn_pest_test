<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FourthTestResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'links' => [
                'first' => $this->url(1),
                'prev' => $this->previousPageUrl(),
                'next' => $this->nextPageUrl()
            ],
            'meta' => [
                'first_page_url' => $this->url(1),
                'from' => $this->firstItem(),
                'next_page_url' => $this->nextPageUrl(),
                'path' => $this->path(),
                'per_page' => (int)$this->perPage(),
                'prev_page_url' => $this->previousPageUrl(),
                'to' => $this->lastItem()
            ]
        ];
    }
}
