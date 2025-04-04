<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrimaryFolder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_id',
        'year_id'
    ];

    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'year_id' => 'integer'
    ];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class, 'year_id')->withDefault([
            'name' => 'N/A' // Provides default if relationship is null
        ]);
    }
    
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id')->withDefault([
            'name' => 'N/A' // Provides default if relationship is null
        ]);
    }

    public function subfolders(): HasMany
    {
        return $this->hasMany(Subfolder::class, 'primary_folder_id');
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::updating(function ($model) {
            // Add any pre-update logic here
        });

        static::updated(function ($model) {
            // Add any post-update logic here
        });
    }
}