<?php

namespace App\Livewire;

use App\Enums\PermissionName;
use App\Models\Player;
use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use Livewire\Component;

class CreatePlayerNote extends Component
{
    public Player $player;

    public string $content = '';

    // Validation state. Kept as the $rules property so validate() reads it directly.
    protected array $rules = [
        'content' => 'required|string|max:1000',
    ];

    // A method (not a property) so the strings can be translated at request time.
    protected function messages(): array
    {
        return [
            'content.required' => __('notes.note_content_required'),
            'content.max' => __('notes.note_content_max'),
        ];
    }

    private PlayerNoteRepositoryInterface $notes;

    // Container resolves the contract every request — the SOLID seam.
    public function boot(PlayerNoteRepositoryInterface $notes): void
    {
        $this->notes = $notes;
    }

    public function save(): void
    {
        // Permission enforced server-side, not just by hiding the form.
        abort_unless(auth()->user()?->can(PermissionName::CreateNotes->value), 403);

        $this->validate();

        $this->notes->create($this->player->id, auth()->id(), $this->content);

        $this->reset('content');

        // Livewire 3 renamed emit() to dispatch(). The note list listens for this
        // event and refreshes itself, so the table updates without a page reload.
        $this->dispatch('note-created');
    }

    public function render()
    {
        return view('livewire.create-player-note');
    }
}
