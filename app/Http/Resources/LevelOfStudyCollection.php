<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LevelOfStudyCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => LevelOfStudyResource::collection($this->collection),
        ];
    }
}
