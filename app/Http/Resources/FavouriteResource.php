<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'original_title' => $this->resource->original_title,
            'overview' => $this->resource->overview,
            'poster_path' => $this->resource->poster_path,
            'backdrop_path' => $this->resource->backdrop_path,
            'createdAt' => $this->resource->created_at->diffForHumans(),
            'updatedAt' => $this->resource->updated_at->diffForHumans(),
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
