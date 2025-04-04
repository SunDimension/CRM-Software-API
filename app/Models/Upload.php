<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_name',
        'file_path',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'file_path' => 'string',
    ];

    /**
     * Get the upload docs that belong to this file.
     */
       public function uploadDoc()
    {
        return $this->hasOne(UploadDoc::class, 'attach_file', 'id');
    }

    public function getFullPathAttribute()
    {
        return storage_path('app/public/' . $this->file_path);
    }
    
    public function getPublicUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}

