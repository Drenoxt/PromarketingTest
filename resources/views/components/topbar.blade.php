@props(['width' => 'max-w-2xl'])

<div {{ $attributes->merge(['class' => "mx-auto mb-4 flex $width items-center justify-between px-1 text-sm"]) }}>
    <span class="text-gray-600 dark:text-gray-400">
        {{ __('notes.signed_in_as', ['name' => auth()->user()->name]) }}
    </span>
    <div class="flex items-center gap-3">
        <x-locale-switcher />
        @can(\App\Enums\PermissionName::ViewDashboard->value)
            <a href="{{ route('dashboard') }}" class="rounded-lg border border-gray-300 px-3 py-1.5 font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                {{ __('notes.dashboard') }}
            </a>
        @endcan
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="rounded-lg border border-gray-300 px-3 py-1.5 font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                {{ __('notes.log_out') }}
            </button>
        </form>
    </div>
</div>
