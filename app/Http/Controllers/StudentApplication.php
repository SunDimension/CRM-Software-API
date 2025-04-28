<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentApplication extends JsonResource
{

  
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'school_id' => $this->school_id,
            'school_name' => $this->school ? $this->school->name : null,
            'product_id' => $this->product_id,
            'gender_id' => $this->gender_id,
            'gender_name' => $this->gender ? $this->gender->name : null,
            'store_id' => $this->store_id,
            'user_id' => $this->user_id,
            'store_name' => $this->store ? $this->store->name : null,
            'user_name' => $this->user ? $this->user->name : null,
            'sales_order_number' => $this->sales_order_number,
            'credit_limit' => $this->credit_limit,
            'credit_balance' => $this->credit_balance,
            'total_amount' => $this->total_amount,
            'payment_type' => $this->payment_type,
            'created_at' => $this->created_at,
           
        ];
    }
}
