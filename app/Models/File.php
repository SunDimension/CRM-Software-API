<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    // Ensure 'path' is fillable to store file locations in the database
    protected $fillable = ['path'];
}
