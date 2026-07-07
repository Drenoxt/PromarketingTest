{{--
    Composes the two Livewire components into a single card:
    the form emits 'note-created', the list listens and refreshes.
    Usage: <x-player-notes :player="$player" />
--}}
@props(['player'])

<div class="mx-auto max-w-2xl rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
    <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800">
        <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ __('notes.notes') }}</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $player->username }}</p>
    </div>

    <livewire:create-player-note :player="$player" />
    <livewire:player-note-list :player="$player" />
</div>
