@props(['title' => 'Player Notes'])
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css'])
    <style>[x-cloak]{display:none!important}</style>
    @livewireStyles
</head>
<body class="min-h-screen bg-gray-100 py-12 dark:bg-gray-950">
    {{ $slot }}
    @livewireScripts
</body>
</html>
