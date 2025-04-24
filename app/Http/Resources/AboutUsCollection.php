<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AboutUsCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => AboutUsResource::collection($this->collection),
        ];
    }
}