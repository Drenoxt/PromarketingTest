<?php

namespace Tests\Feature;

use App\Enums\PermissionName;
use App\Livewire\CreatePlayerNote;
use App\Livewire\PlayerNoteList;
use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PlayerNotesTest extends TestCase
{
    use RefreshDatabase;

    private function agentWithPermission(): User
    {
        $permissions = [PermissionName::ViewNotes->value, PermissionName::CreateNotes->value];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        $user = User::create([
            'name' => 'Support Agent',
            'email' => 'agent@example.com',
            'password' => 'secret',
        ]);

        return $user->givePermissionTo($permissions);
    }

    public function test_a_note_is_saved_to_the_database(): void
    {
        $agent = $this->agentWithPermission();
        $player = Player::create(['username' => 'player_one']);

        Livewire::actingAs($agent)
            ->test(CreatePlayerNote::class, ['player' => $player])
            ->set('content', 'Reported for chat abuse.')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('player_notes', [
            'player_id' => $player->id,
            'user_id' => $agent->id,
            'content' => 'Reported for chat abuse.',
        ]);
    }

    public function test_it_clears_the_form_and_emits_the_refresh_event_after_saving(): void
    {
        $agent = $this->agentWithPermission();
        $player = Player::create(['username' => 'player_one']);

        Livewire::actingAs($agent)
            ->test(CreatePlayerNote::class, ['player' => $player])
            ->set('content', 'Reported for chat abuse.')
            ->call('save')
            ->assertSet('content', '')
            ->assertDispatched('note-created');
    }

    public function test_it_rejects_an_empty_note(): void
    {
        $agent = $this->agentWithPermission();
        $player = Player::create(['username' => 'player_one']);

        Livewire::actingAs($agent)
            ->test(CreatePlayerNote::class, ['player' => $player])
            ->set('content', '')
            ->call('save')
            ->assertHasErrors(['content' => 'required']);

        $this->assertDatabaseCount('player_notes', 0);
    }

    public function test_the_list_refreshes_when_a_note_is_created(): void
    {
        $agent = $this->agentWithPermission();
        $player = Player::create(['username' => 'player_one']);

        $list = Livewire::actingAs($agent)
            ->test(PlayerNoteList::class, ['player' => $player])
            ->assertSee('No notes yet.');

        // The list listens for 'note-created' and re-renders with the new note.
        $player->notes()->create([
            'user_id' => $agent->id,
            'content' => 'Fresh note.',
        ]);

        $list->dispatch('note-created')
            ->assertSee('Fresh note.')
            ->assertDontSee('No notes yet.');
    }
}
