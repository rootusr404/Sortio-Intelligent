<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participant extends Model
{
    protected $fillable = [
        'draw_id',
        'full_name',
        'group_id',
        'theme_name',
        'position_in_draw',
    ];

    public function draw(): BelongsTo
    {
        return $this->belongsTo(Draw::class);
    }
}
