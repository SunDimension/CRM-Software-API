<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProgramChoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'country_id',
        'university_id',
        'program_id',
        'first_choice',
        'second_choice',
        'third_choice',
        'is_completed',
    ];

    public function student()
    {
        return $this->belongsTo(StudentPersonalInformation::class, 'student_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
