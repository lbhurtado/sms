<?php

namespace LBHurtado\SMS\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Get the registered name of the component.
 *
 * @return string
 *
 * @throws \RuntimeException
 */
class SMS extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sms';
    }
}
