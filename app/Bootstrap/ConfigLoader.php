<?php

namespace App\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;
use Illuminate\Contracts\Config\Repository as RepositoryContract;

class ConfigLoader extends LoadConfiguration
{
    /**
     * {@inheritdoc}
     */
    protected function loadConfigurationFiles(Application $app, RepositoryContract $repository)
    {
        parent::loadConfigurationFiles($app, $repository);

        if ( ! $app->runningInConsole()) {
            $app['venture']->loadVentureConfigs();
        }
    }
}
