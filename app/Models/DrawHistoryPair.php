<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DrawHistoryPair extends Model
{
    protected $fillable = [
        'user_id',
        'draw_id',
        'participant_pair_hash',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function draw(): BelongsTo
    {
        return $this->belongsTo(Draw::class);
    }
}
