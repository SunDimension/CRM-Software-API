<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramChoiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'country' => $this->country->name,
            'university' => $this->university->name,
            'program' => $this->program->name,
            'first_choice' => $this->first_choice,
            'second_choice' => $this->second_choice,
            'third_choice' => $this->third_choice,
            'is_completed' => $this->is_completed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}