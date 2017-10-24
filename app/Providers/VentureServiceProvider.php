<?php

namespace App\Providers;

use Illuminate\Config\Repository;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\ServiceProvider;

class VentureServiceProvider extends ServiceProvider
{

    /**
     * Register venture specific services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('db', function ($app) {
            config(['database.connections.pgsql.schema' => $app['venture']->resolveVenture()]);

            return new DatabaseManager($app, $app['db.factory']);
        });

        /*
         * Create db and config instance for each venture.
         */
        foreach ($this->app['venture']->getAllVentures() as $venture) {
            // Venture specific dbs.
            $this->app->singleton('db.' . $venture, function ($app) use ($venture) {
                config(['database.connections.pgsql.schema' => $venture]);

                return new DatabaseManager($app, $app['db.factory']);
            });

            // Venture specific configs.
            $this->app->singleton('config.' . $venture, function ($app) use ($venture) {
                $config = new Repository($app['config']->all());

                $app['venture']->loadVentureConfigs($venture, $config);

                return $config;
            });
        }
    }
}
