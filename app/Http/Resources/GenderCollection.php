<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GenderCollection extends ResourceCollection
{
        // In GenderCollection.php
public function toArray($request)
{
    // Just return the collection directly - it will be automatically wrapped in 'data'
    return $this->collection;
}
    }
