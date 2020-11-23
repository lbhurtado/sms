<?php

namespace LBHurtado\SMS\Drivers;

class NullDriver extends Driver
{
    /**
     * {@inheritdoc}
     */
    public function send()
    {
        return [];
    }

    public function topup(int $amount)
    {
        // TODO: Implement topup() method.
    }
}
