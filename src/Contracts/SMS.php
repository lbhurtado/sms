<?php

namespace LBHurtado\SMS\Contracts;

interface SMS
{
    /**
     * Send the given message to the given recipient.
     *
     * @return mixed
     */
    public function send();
}
