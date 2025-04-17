<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentEmergencyContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'name',
        'relationship',
        'phone_number',
        'email',
        'is_completed'
    ];

    public function student()
    {
        return $this->belongsTo(StudentPersonalInformation::class, 'student_id');
    }
}