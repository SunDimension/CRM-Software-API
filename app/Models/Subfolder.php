<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subfolder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'primary_folder_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'primary_folder_id' => 'integer',
    ];

// In app/Models/Subfolder.php
public function primaryFolder()
{
    return $this->belongsTo(PrimaryFolder::class, 'primary_folder_id')
        ->withDefault([ // Provides default values if relationship is null
            'name' => 'N/A',
            'company' => (object) ['name' => 'N/A']
        ]);
}
    
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id')
            ->withDefault([
                'name' => 'N/A'
            ]);
    }

    public function uploadDocs(): HasMany
    {
        return $this->hasMany(UploadDoc::class, 'subfolder_id');
    }
}