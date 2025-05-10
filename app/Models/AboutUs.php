<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'about_us';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'name_of_referal',
        'social_media_id',
        'parent_guardian',
        'government',
        'ngo',
        'self',
        'phone_number',
        'ielts_toefl',
        'gre',
        'is_completed',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_completed' => 'boolean',
    ];

    /**
     * Get the student that owns this AboutUs record.
     */
    public function student()
    {
        return $this->belongsTo(StudentPersonalInformation::class, 'student_id');
    }

    /**
     * Get the social media that is associated with this AboutUs record.
     */
    public function socialMedia()
    {
        return $this->belongsTo(SocialMedia::class, 'social_media_id');
    }
}