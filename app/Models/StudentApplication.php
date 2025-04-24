<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'school_id',
        'gender_id',
        'martital_id',
        'fathers_name',
        'mothers_name',
        'phone_number'
    ];

    protected $cast = [

        'id' => 'integer',
        'school_id' =>'integer',
        'marital_id'=>'integer',
        'gender_id'=>'integer',

    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class,'gender_id');
    }

    // public function marital()
    // {
    //     return $this->belongsTo(Marital::class,'marital_id');
    // }
    
    // public function student()
    // {
    //     return $this->hasMany(Student::class, 'student_application_id');
    // }
}
