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

    /**
     * Topup the given amount to the given recipient.
     *
     * @param int $amount
     * @return mixed
     */
    public function topup(int $amount);
}
