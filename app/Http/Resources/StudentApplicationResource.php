<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubfolderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'primary_folder_id' => $this->primary_folder_id,
            'primary_folder_name' => $this->whenLoaded('primaryFolder', function () {
                return $this->primaryFolder->name ?? null;
            }),
            'company_name' => $this->when(
                $this->relationLoaded('primaryFolder') && 
                $this->primaryFolder->relationLoaded('company'),
                function () {
                    return $this->primaryFolder->company->name ?? null;
                }
            ),
        ];
    }
}