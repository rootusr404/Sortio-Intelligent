<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Constraint extends Model
{
    protected $fillable = [
        'draw_id',
        'type',
        'participant_ids',
        'satisfied',
        'failure_reason',
    ];

    protected function casts(): array
    {
        return [
            'participant_ids' => 'array',
            'satisfied' => 'boolean',
        ];
    }

    public function draw(): BelongsTo
    {
        return $this->belongsTo(Draw::class);
    }
}
