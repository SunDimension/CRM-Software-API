<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PersonalInformationCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => PersonalInformationResource::collection($this->collection),
        ];
    }
}