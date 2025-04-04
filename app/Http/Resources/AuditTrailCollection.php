<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AuditTrailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => AuditTrailResource::collection($this->collection),
            'links' => [
                'self' => url($request->path()),
            ],
        ];
    }
}