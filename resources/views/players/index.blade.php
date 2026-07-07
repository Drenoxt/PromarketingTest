<x-layout :title="__('notes.players')">
    <x-topbar />

    <div class="mx-auto max-w-2xl">
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800">
                <h1 class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ __('notes.players') }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('notes.players_subtitle') }}</p>
            </div>

            <ul role="list" class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse ($players as $player)
                    <li>
                        <a href="{{ route('players.show', $player) }}"
                           class="flex items-center justify-between gap-3 px-6 py-4 transition hover:bg-gray-50 dark:hover:bg-gray-800">
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                                    {{ strtoupper(mb_substr($player->username, 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $player->username }}</span>
                            </div>
                            <span class="rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                {{ trans_choice('notes.notes_count', $player->notes_count) }}
                            </span>
                        </a>
                    </li>
                @empty
                    <li class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">{{ __('notes.no_players') }}</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-layout>
