<?php
// app/Http/Resources/MaritalStatusCollection.php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MaritalStatusCollection extends ResourceCollection
{
    public function toArray($request)
{
    // Just return the collection directly - it will be automatically wrapped in 'data'
    return $this->collection;
}
    
}
