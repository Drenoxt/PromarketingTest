<?php

namespace App\Repositories;

use App\Models\PlayerNote;
use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use Illuminate\Support\Collection;

class PlayerNoteRepository implements PlayerNoteRepositoryInterface
{
    public function getForPlayer(int $playerId): Collection
    {
        return PlayerNote::query()
            ->with('author:id,name')
            ->where('player_id', $playerId)
            ->latest()
            ->get();
    }

    public function getAll(): Collection
    {
        return PlayerNote::query()
            ->with(['author:id,name', 'player:id,username'])
            ->latest()
            ->get();
    }

    public function create(int $playerId, int $authorId, string $content): PlayerNote
    {
        return PlayerNote::create([
            'player_id' => $playerId,
            'user_id' => $authorId,
            'content' => $content,
        ]);
    }
}
