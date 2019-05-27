<?php

namespace LBHurtado\SMS\Tests;

use LBHurtado\SMS\SMSManager;
use LBHurtado\SMS\SMSServiceProvider;
use LBHurtado\EngageSpark\EngageSparkServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            SMSServiceProvider::class,
            EngageSparkServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'SMS' => SMSManager::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('engagespark.api_key', 'b3867ab758b3fea05a4f40124e0e4f52c399ed12');
        $app['config']->set('engagespark.org_id', '7858');
    }
}
