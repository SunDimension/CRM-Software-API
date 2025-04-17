<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'document_name',
        'document_type',
        'file_path',
        'is_completed'
    ];

    public function student()
    {
        return $this->belongsTo(StudentPersonalInformation::class, 'student_id');
    }
}
