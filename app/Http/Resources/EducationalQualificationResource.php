<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EducationalQualificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'qualification_name' => $this->qualification_name,
            'country' => $this->country->name,
            'qualification_obtained' => $this->qualification_obtained,
            'grade' => $this->grade,
            'institution_name' => $this->institution_name,
            'year_started' => $this->yearStarted->year,
            'qualification_order' => $this->qualification_order,
            'is_completed' => $this->is_completed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}