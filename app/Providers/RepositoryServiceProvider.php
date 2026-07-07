<?php

namespace App\Providers;

use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use App\Repositories\PlayerNoteRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            PlayerNoteRepositoryInterface::class,
            PlayerNoteRepository::class,
        );
    }
}
