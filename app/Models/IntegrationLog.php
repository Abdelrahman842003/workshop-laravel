<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IntegrationLog extends Model
{
    use HasFactory, Prunable;

    public $timestamps = false; // We use occurred_at

    protected $guarded = ['id'];

    protected $casts = [
        'payload_summary' => 'array',
        'response_data' => 'array',
        'occurred_at' => 'datetime',
    ];

    public function integration(): BelongsTo
    {
        return $this->belongsTo(Integration::class);
    }

    /**
     * Get the prunable model query.
     */
    public function prunable()
    {
        // Delete logs older than 30 days
        return static::where('occurred_at', '<=', now()->subDays(30));
    }
}
