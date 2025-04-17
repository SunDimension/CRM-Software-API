<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentEducationalQualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'qualification_name',
        'country_id',
        'qualification_obtained',
        'grade',
        'institution_name',
        'year_started_id',
        'qualification_order',
        'is_completed'
    ];

    public function student()
    {
        return $this->belongsTo(StudentPersonalInformation::class, 'student_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function yearStarted()
    {
        return $this->belongsTo(Year::class, 'year_started_id');
    }
}
