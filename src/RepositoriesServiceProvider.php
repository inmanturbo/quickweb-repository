<?php

namespace Quickweb\Repositories;

use Illuminate\Support\Str;
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
        
        Str::macro('fromCamelCase', function ($input) {

            preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
            $ret = $matches[0];
            foreach ($ret as &$match) {
                $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
            }
            return implode('_', $ret);
        });

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

        $this->mergeConfigFrom(__DIR__ . '/../config/quickwebrepository.php', 'quickwebrepository');
    }
}
