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
}
