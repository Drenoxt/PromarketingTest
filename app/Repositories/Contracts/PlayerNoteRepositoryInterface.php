<?php

namespace App\Repositories\Contracts;

use App\Models\PlayerNote;
use Illuminate\Support\Collection;

interface PlayerNoteRepositoryInterface
{
    /**
     * Notes for a player, newest first, with the author eager loaded.
     *
     * @return Collection<int, PlayerNote>
     */
    public function getForPlayer(int $playerId): Collection;

    /**
     * Every note across all players, for the admin dashboard.
     *
     * @return Collection<int, PlayerNote>
     */
    public function getAll(): Collection;

    public function create(int $playerId, int $authorId, string $content): PlayerNote;
}
