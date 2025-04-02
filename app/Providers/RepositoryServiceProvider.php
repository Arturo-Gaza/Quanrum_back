<?php

namespace App\Providers;

use App\Interface\Catalogos\catCategoriasRepositoryInterface;
use App\Interface\Catalogos\catRolesRepositoryInterface;
use App\Interface\Usuario\UsuariosRepositoryInterface;
use App\Repositories\Catalogos\catCategoriaRepository;
use App\Repositories\Catalogos\catRolesRepository;
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
        $this->app->bind(catRolesRepositoryInterface::class, catRolesRepository::class);
        $this->app->bind(catCategoriasRepositoryInterface::class, catCategoriaRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
