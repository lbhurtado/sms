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
}
