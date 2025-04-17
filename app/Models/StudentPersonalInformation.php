<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPersonalInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_name',
        'gender_id',
        'date_of_birth',
        'phone_number',
        'email',
        'marital_status_id',
        'father_name',
        'mother_name',
        'passport_number',
        'passport_issued_date',
        'passport_expiry_date',
        'postal_address',
        'is_completed'
    ];

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatus::class);
    }

    public function emergencyContacts()
    {
        return $this->hasMany(StudentEmergencyContact::class, 'student_id');
    }

    public function educationalQualifications()
    {
        return $this->hasMany(StudentEducationalQualification::class, 'student_id');
    }

    public function programChoices()
    {
        return $this->hasMany(StudentProgramChoice::class, 'student_id');
    }

    public function documents()
    {
        return $this->hasMany(StudentDocument::class, 'student_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}