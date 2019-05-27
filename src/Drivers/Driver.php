<?php

namespace LBHurtado\SMS\Drivers;

use LBHurtado\SMS\Contracts\SMS;
use LBHurtado\SMS\Exceptions\SMSException;

abstract class Driver implements SMS
{
    /**
     * The sender of the message.
     *
     * @var string
     */
    protected $sender;

    /**
     * The recipient of the message.
     *
     * @var string
     */
    protected $recipient;

    /**
     * The message to send.
     *
     * @var string
     */
    protected $message;

    /**
     * The amount to topup.
     *
     * @var integer
     */
    protected $amount;

    /**
     * {@inheritdoc}
     */
    abstract public function send();

    /**
     * {@inheritdoc}
     */
    abstract public function topup(int $amount);

    /**
     * Set the sender of the message.
     *
     * @param string $sender
     * @return $this
     * @throws \Throwable
     */
    public function from(string $sender)
    {
        throw_if(is_null($sender), SMSException::class, 'Sender cannot be empty');

        $this->sender = $sender;

        return $this;
    }

    /**
     * Set the recipient of the message.
     *
     * @param string $recipient
     * @return $this
     * @throws \Throwable
     */
    public function to(string $recipient)
    {
        throw_if(is_null($recipient), SMSException::class, 'Recipients cannot be empty');

        $this->recipient = $recipient;

        return $this;
    }

    /**
     * Set the content of the message.
     *
     * @param string $message
     * @return $this
     * @throws \Throwable
     */
    public function content(string $message)
    {
        throw_if(empty($message), SMSException::class, 'Message text is required');

        $this->message = $message;

        return $this;
    }

    /**
     * Set the amount of the topup.
     *
     * @param int $amount
     * @return $this
     * @throws \Throwable
     */
    public function amount(int $amount)
    {
        throw_if(empty($amount), SMSException::class, 'Topup amount is required');

        $this->amount = $amount;

        return $this;
    }
}
