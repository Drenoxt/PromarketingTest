<?php

namespace App\Enums;

enum Locale: string
{
    case English = 'en';
    case Spanish = 'es';

    public function label(): string
    {
        return match ($this) {
            self::English => 'English',
            self::Spanish => 'Español',
        };
    }
}
