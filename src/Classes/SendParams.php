<?php

namespace LBHurtado\SMS\Classes;

use LBHurtado\SMS\Contracts\Params;

class SendParams implements Params
{
    /**
     * @var int
     */
    protected $org_id;

    /**
     * @var string
     */
    protected $mobile_number;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $sender_id;

    /**
     * @var string
     */
    protected $recipientType = 'mobile_number';

    /**
     * SendParams constructor.
     * @param $org_id
     * @param $mobile_number
     * @param $message
     * @param $sender_id
     */
    public function __construct(int $org_id, string $mobile_number, string $message, string $sender_id = null)
    {
        $this->org_id = $org_id;
        $this->mobile_number = $mobile_number;
        $this->message = $message;
        $this->sender_id = $sender_id; //TODO: read ENGAGESPARK_SENDER_ID from .env
    }

    public function setRecipientType(string $recipientType)
    {
        $this->recipientType = $recipientType;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'organization_id' => $this->org_id,
            'mobile_numbers' => [$this->mobile_number],
            'message' => $this->message,
            'sender_id' => $this->sender_id,
            'recipient_type'  => $this->recipientType,
        ];
    }
}
