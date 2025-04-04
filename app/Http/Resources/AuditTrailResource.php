<?php
// app/Http/Resources/AuditTrailResource.php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuditTrailResource extends JsonResource
{
public function toArray($request)
{
    return [
        'id' => $this->id,
        'action' => $this->action,
        'model_type' => $this->model_type,
        'model_id' => $this->model_id,
        'old_values' => $this->old_values,
        'new_values' => $this->new_values,
        'ip_address' => $this->ip_address,
        'user_agent' => $this->user_agent,
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
        'user' => $this->whenLoaded('user', function () {
            return [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ];
        }),
        'model' => $this->whenLoaded('model'),
    ];
}
}

// app/Http/Resources/AuditTrailCollection.php
