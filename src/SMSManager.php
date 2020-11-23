<?php

namespace LBHurtado\SMS;

use Illuminate\Support\Manager;
use Nexmo\Client as NexmoClient;
use LBHurtado\SMS\Drivers\NullDriver;
use LBHurtado\SMS\Drivers\NexmoDriver;
use LBHurtado\EngageSpark\EngageSpark;
use LBHurtado\SMS\Drivers\EngageSparkDriver;
use Nexmo\Client\Credentials\Basic as NexmoBasicCredentials;

class SMSManager extends Manager
{
    /**
     * Get a driver instance.
     *
     * @param  string|null  $name
     * @return mixed
     */
    public function channel($name = null)
    {
        return $this->driver($name);
    }

    /**
     * Create a Nexmo SMS driver instance.
     *
     * @return \LBHurtado\SMS\Drivers\NexmoDriver
     */
    public function createNexmoDriver()
    {
        return new NexmoDriver(
            $this->createNexmoClient(),
            $this->app['config']['sms.nexmo.from']
        );
    }

    public function createEngageSparkDriver()
    {
        return new EngageSparkDriver(
            app(EngageSpark::class)
        );
    }

    /**
     * Create the Nexmo client.
     *
     * @return \Nexmo\Client
     */
    protected function createNexmoClient()
    {
        return new NexmoClient(
            new NexmoBasicCredentials(
                $this->app['config']['sms.nexmo.key'],
                $this->app['config']['sms.nexmo.secret']
            )
        );
    }

    /**
     * Create a Null SMS driver instance.
     *
     * @return \LBHurtado\SMS\Drivers\NullDriver
     */
    public function createNullDriver()
    {
        return new NullDriver;
    }

    /**
     * Get the default SMS driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->container['config']['sms.default'] ?? 'null';
    }
}
