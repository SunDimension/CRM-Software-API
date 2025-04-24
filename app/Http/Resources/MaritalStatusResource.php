<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaritalStatusResource extends JsonResource
 {
    /**
    * Transform the resource into an array.
    *
    * @return array<string, mixed>
    */
    // app/Http/Resources/MaritalStatusResource.php

    public function toArray( $request )
 {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

}
