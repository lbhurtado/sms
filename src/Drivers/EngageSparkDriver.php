<?php

namespace LBHurtado\SMS\Drivers;

use Illuminate\Support\Str;
use LBHurtado\EngageSpark\EngageSpark;

class EngageSparkDriver extends Driver
{
    const RECIPIENT_TYPE = 'mobile_number';

    protected $client;

    public function __construct(EngageSpark $engageSpark, $from = null)
    {
        $this->client = $engageSpark;

        $this->sender = $from;
    }

    public function send()
    {
        $this->client->send([
            'mobile_numbers'  => [$this->recipient],
            'message'         => $this->message,
            'recipient_type'  => self::RECIPIENT_TYPE,
            'sender_id'       => $this->sender,
            'organization_id' => $this->getOrgId(), //TODO: fix this
        ], 'sms');

        return $this;
    }

    public function topup(int $amount)
    {
        $this->client->send([
            'phoneNumber'     => $this->recipient,
            'maxAmount'       => $amount,
            'clientRef'       => Str::random(6),
            'organizationId'  => $this->getOrgId(), //TODO: fix this
        ], 'topup');

        return $this;
    }

    public function client()
    {
        return $this->client;
    }

    public function getOrgId()
    {
        return $this->client()->getOrgId();
    }
}
