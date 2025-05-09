<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UploadDoc extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_title',
        'filetype_id',
        'attach_file',
    ];


  public function fileType()
{
    return $this->belongsTo(FileType::class, 'filetype_id'); // ✅ Correctly map filetype_id
}


   public function upload()
{
    return $this->belongsTo(Upload::class, 'attach_file', 'id');
}


   public function getFileUrlAttribute()
{
    return $this->attach_file ? Storage::url($this->attach_file) : null;
}

}
