<?php

namespace App\Providers;

use App\Interface\Usuario\UsuariosRepositoryInterface;
use App\Repositories\Usuario\UsuarioRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(UsuariosRepositoryInterface::class, UsuarioRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
