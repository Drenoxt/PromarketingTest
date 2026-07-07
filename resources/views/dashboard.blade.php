<x-layout :title="__('notes.notes_dashboard')">
    <div class="mx-auto max-w-4xl px-4">

        {{-- Top bar --}}
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ __('notes.notes_dashboard') }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('notes.notes_dashboard_subtitle') }}</p>
            </div>
            <div class="flex items-center gap-3 text-sm">
                <x-locale-switcher />
                <a href="{{ route('players.index') }}" class="rounded-lg border border-gray-300 px-3 py-1.5 font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                    {{ __('notes.players') }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-lg border border-gray-300 px-3 py-1.5 font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                        {{ __('notes.log_out') }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Stat tiles --}}
        <div class="mb-6 grid grid-cols-3 gap-4">
            @foreach ([
                __('notes.total_notes') => $notes->count(),
                __('notes.players') => $notes->pluck('player_id')->unique()->count(),
                __('notes.authors') => $notes->pluck('user_id')->unique()->count(),
            ] as $label => $value)
                <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-900">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">{{ $label }}</p>
                    <p class="mt-1 text-2xl font-semibold tabular-nums text-gray-900 dark:text-gray-100">{{ $value }}</p>
                </div>
            @endforeach
        </div>

        {{-- Notes table --}}
        <div class="overflow-x-auto rounded-2xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-gray-100 text-xs uppercase tracking-wide text-gray-400 dark:border-gray-800">
                    <tr>
                        <th class="px-6 py-3 font-medium">{{ __('notes.date') }}</th>
                        <th class="px-6 py-3 font-medium">{{ __('notes.player') }}</th>
                        <th class="px-6 py-3 font-medium">{{ __('notes.author') }}</th>
                        <th class="px-6 py-3 font-medium">{{ __('notes.content') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($notes as $note)
                        <tr>
                            <td class="whitespace-nowrap px-6 py-3 text-gray-500 dark:text-gray-400">{{ $note->created_at->format('Y-m-d H:i') }}</td>
                            <td class="whitespace-nowrap px-6 py-3 text-gray-700 dark:text-gray-300">{{ $note->player->username ?? '—' }}</td>
                            <td class="whitespace-nowrap px-6 py-3 text-gray-700 dark:text-gray-300">{{ $note->author->name ?? __('notes.unknown_author') }}</td>
                            <td class="px-6 py-3 text-gray-700 dark:text-gray-300">{{ $note->content }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">{{ __('notes.no_notes_yet') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
