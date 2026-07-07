<?php

namespace App\Livewire;

use App\Models\Player;
use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use Livewire\Component;

class PlayerNoteList extends Component
{
    public Player $player;

    // Listener state: when CreatePlayerNote dispatches 'note-created', the built-in
    // $refresh action re-renders this component, reloading the table with no reload.
    protected $listeners = [
        'note-created' => '$refresh',
    ];

    private PlayerNoteRepositoryInterface $notes;

    public function boot(PlayerNoteRepositoryInterface $notes): void
    {
        $this->notes = $notes;
    }

    public function render()
    {
        return view('livewire.player-note-list', [
            'notes' => $this->notes->getForPlayer($this->player->id),
        ]);
    }
}
