<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Integration extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'credentials' => 'encrypted:json', // Automatically encrypt/decrypt
        'settings' => 'array',
        'last_sync_at' => 'datetime',
    ];

    public function fieldMappings(): HasMany
    {
        return $this->hasMany(IntegrationFieldMapping::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(IntegrationLog::class);
    }
}
