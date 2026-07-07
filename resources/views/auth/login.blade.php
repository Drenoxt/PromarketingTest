<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('notes.sign_in') }} — Player Notes</title>
    @vite(['resources/css/app.css'])
</head>
<body class="flex min-h-screen items-center justify-center bg-gray-100 px-4 dark:bg-gray-950">
    <div class="w-full max-w-sm rounded-2xl border border-gray-200 bg-white p-8 shadow-sm dark:border-gray-700 dark:bg-gray-900">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('notes.sign_in') }}</h1>
            <x-locale-switcher />
        </div>

        <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('notes.email') }}</label>
                <input
                    id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                    class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                >
                @error('email')
                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('notes.password') }}</label>
                <input
                    id="password" name="password" type="password" required
                    class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                >
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                {{ __('notes.remember_me') }}
            </label>

            <button type="submit" class="w-full rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                {{ __('notes.sign_in') }}
            </button>
        </form>

        {{-- Seeded demo accounts (all share the same password) --}}
        <div class="mt-6 rounded-lg bg-gray-50 p-3 text-xs text-gray-500 dark:bg-gray-800 dark:text-gray-400">
            <p class="font-medium text-gray-600 dark:text-gray-300">{{ __('notes.demo_accounts') }}</p>
            <p>admin@example.com — {{ __('notes.demo_admin') }}</p>
            <p>agent@example.com — {{ __('notes.demo_agent') }}</p>
            <p>viewer@example.com — {{ __('notes.demo_viewer') }}</p>
            <p class="mt-1">{{ __('notes.demo_password_label') }}: <span class="font-mono">1234$</span></p>
        </div>
    </div>
</body>
</html>
