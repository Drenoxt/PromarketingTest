<div>
    {{-- Whole block is permission-gated; renders nothing for read-only agents. --}}
    @can(\App\Enums\PermissionName::CreateNotes->value)
        <form wire:submit="save" class="border-b border-gray-100 px-6 py-4 dark:border-gray-800">
            <label for="note-content" class="sr-only">New note</label>

            <div x-data="{ len: @js(strlen($content)) }">
                <textarea
                    id="note-content"
                    wire:model="content"
                    x-on:input="len = $event.target.value.length"
                    x-on:note-created.window="len = 0"
                    rows="3"
                    maxlength="1000"
                    placeholder="{{ __('notes.note_placeholder') }}"
                    class="block w-full resize-y rounded-lg border-gray-300 text-sm text-gray-900 shadow-sm placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                ></textarea>

                <div class="mt-2 flex items-center justify-between">
                    <p class="text-xs text-red-600 dark:text-red-400" aria-live="polite">
                        @error('content') {{ $message }} @enderror
                    </p>
                    <span class="text-xs tabular-nums text-gray-400"><span x-text="len">0</span>/1000</span>
                </div>
            </div>

            <div class="mt-3 flex justify-end">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="save"
                    class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60 dark:focus:ring-offset-gray-900"
                >
                    <svg wire:loading wire:target="save" class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="save">{{ __('notes.add_note') }}</span>
                    <span wire:loading wire:target="save">{{ __('notes.saving') }}</span>
                </button>
            </div>
        </form>
    @endcan
</div>
