<div class="flex items-center gap-1 text-sm">
    @foreach (\App\Enums\Locale::cases() as $locale)
        <form method="POST" action="{{ route('locale.switch', $locale->value) }}">
            @csrf
            <button
                type="submit"
                class="rounded-lg px-2 py-1 font-medium transition {{ app()->getLocale() === $locale->value
                    ? 'bg-blue-600 text-white'
                    : 'text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}"
            >
                {{ strtoupper($locale->value) }}
            </button>
        </form>
    @endforeach
</div>
