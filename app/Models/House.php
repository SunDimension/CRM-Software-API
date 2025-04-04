<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'company_id',
        'year_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id'=>'integer',
        'year_id'=>'integer'
    ];


        public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }
    
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}


