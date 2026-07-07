<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
    ];

    // The uuid is the player's public identifier; the integer id stays in the backend.
    protected $hidden = ['id'];

    protected static function booted(): void
    {
        static::creating(function (Player $player): void {
            $player->uuid ??= (string) Str::uuid();
        });
    }

    // Route-model binding resolves players by uuid, so URLs never expose the id.
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function notes(): HasMany
    {
        return $this->hasMany(PlayerNote::class);
    }
}
