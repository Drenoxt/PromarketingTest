<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'user_id',
        'content',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /** The support agent who wrote the note. */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
