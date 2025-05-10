<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    
    

    protected $fillable = [
        
        'user_id',
        'gender_id',
        'maritalstatus_id',
        'student_name',
        'date_of_birth',
        'phone_number',
        'email',
        'father_name',
        'mother_name',
        'passport_number',
        'passport_issue_date',
        'postal_address',
    ];

    protected $cast = [
        'date_of_birth' => 'date',
        'passport_issue_date' => 'date',
        'user_id'=>'integer',
        'maritalstatus_id' => 'integer',
        'gender_id' => 'integer',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function gender() {
        return $this->belongsTo(Gender::class);
    }

    public function maritalStatus() {
        return $this->belongsTo(MaritalStatus::class, 'maritalstatus_id');
    }
}
