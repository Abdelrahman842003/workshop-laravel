<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IntegrationFieldMapping extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function integration(): BelongsTo
    {
        return $this->belongsTo(Integration::class);
    }
}
