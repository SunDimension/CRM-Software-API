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
        'qualification_obtained_id',
        'grade',
        'institution_name',
        'year_started_id',
        'year_finished_id',
        'qualification_order',
        'is_completed'
    ];

    // Cast 'is_completed' to boolean
    protected $casts = [
        'is_completed' => 'boolean',
    ];

    // Optional global scope to always order by qualification_order
    protected static function booted()
    {
        static::addGlobalScope('ordered', function ($query) {
            $query->orderBy('qualification_order');
        });
    }

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
