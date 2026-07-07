<x-layout :title="'Notes · '.$player->username">
    <x-topbar />

    <div class="mx-auto mb-4 max-w-2xl px-1">
        <a href="{{ route('players.index') }}" class="text-sm text-gray-500 transition hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            &larr; {{ __('notes.all_players') }}
        </a>
    </div>

    <x-player-notes :player="$player" />
</x-layout>
