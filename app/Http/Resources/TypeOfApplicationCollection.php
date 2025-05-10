<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TypeOfApplicationCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => TypeOfApplicationResource::collection($this->collection),
        ];
    }
}