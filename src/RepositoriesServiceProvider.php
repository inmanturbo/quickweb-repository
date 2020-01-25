<?php

namespace Quickweb\Repositories;


use Quickweb\Repositories\Repositories\Repository;
use Quickweb\Repositories\Repositories\TableRepositoryInterface;
use Quickweb\Repositories\Repositories\FieldRepositoryInterface;
use Illuminate\Database\ConnectionResolverInterface as Base;

use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{



    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->publishes(
            [
                __DIR__ . '/../config/quickwebrepository.php' => config_path('quickwebrepository.php')
            ],
            'config'
        );

        $this->app->bind(TableRepositoryInterface::class, Repository::class);
        $this->app->bind(FieldRepositoryInterface::class, Repository::class);
    }

    /**
     * Provider register
     *
     * @return null
     */
    public function register()
    {
        $this->app->bind(
            'brotzka-dotenveditor',
            function () {
                $base = new Base;
                return new Repository($base);
            }
        );

        $this->mergeConfigFrom(__DIR__ . '/../config/quickwebrepository.php', 'quickwebrepository');
    }
}
