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
        'file_description',
        'subfolder_id',
        'filetype_id',
        'attach_file',
        'file_expiry_date',
        'financial_value',
        'approval_comment',
        'status',
        'approval_date',
        'approval_date',
        'approved_by',
    ];

  public function subfolder()
    {
        return $this->belongsTo(Subfolder::class, 'subfolder_id');
    }

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
