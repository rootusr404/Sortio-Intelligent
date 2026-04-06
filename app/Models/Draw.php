<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Draw extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'type',
        'parameters',
        'participant_count',
        'seed',
        'hash_input_snapshot',
        'hash_code',
        'locked_at',
        'anonymized_at',
    ];

    protected function casts(): array
    {
        return [
            'parameters' => 'array',
            'locked_at' => 'datetime',
            'anonymized_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function constraints(): HasMany
    {
        return $this->hasMany(Constraint::class);
    }

    public function isAnonymized(): bool
    {
        return !is_null($this->anonymized_at);
    }
}
