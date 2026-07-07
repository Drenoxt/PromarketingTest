<div>
    @cannot(\App\Enums\PermissionName::ViewNotes->value)
        <p class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
            {{ __('notes.no_view_permission') }}
        </p>
    @else
    @if ($notes->isNotEmpty())
        <p class="px-6 pt-4 text-xs font-medium uppercase tracking-wide text-gray-400">
            {{ trans_choice('notes.notes_count', $notes->count()) }}
        </p>
    @endif

    <ul role="list" class="divide-y divide-gray-100 dark:divide-gray-800">
        @forelse ($notes as $note)
            <li class="flex gap-3 px-6 py-4">
                {{-- Author avatar: initials --}}
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                    {{ strtoupper(mb_substr($note->author->name ?? '?', 0, 1)) }}
                </div>

                <div class="min-w-0 flex-1">
                    <div class="flex items-center justify-between gap-2">
                        <p class="truncate text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ $note->author->name ?? __('notes.unknown_author') }}
                        </p>
                        <time
                            datetime="{{ $note->created_at->toIso8601String() }}"
                            title="{{ $note->created_at->format('Y-m-d H:i') }}"
                            class="shrink-0 text-xs text-gray-400"
                        >
                            {{ $note->created_at->diffForHumans() }}
                        </time>
                    </div>
                    <p class="mt-1 whitespace-pre-line break-words text-sm text-gray-700 dark:text-gray-300">
                        {{ $note->content }}
                    </p>
                </div>
            </li>
        @empty
            <li class="px-6 py-10 text-center">
                <svg class="mx-auto h-8 w-8 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3.75h6m-6 5.25l-3 3V6.75A2.25 2.25 0 016.75 4.5h10.5A2.25 2.25 0 0119.5 6.75v6a2.25 2.25 0 01-2.25 2.25H9.75L7.5 17.25z" />
                </svg>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('notes.no_notes_yet') }}</p>
            </li>
        @endforelse
    </ul>
    @endcannot
</div>
