<?php

namespace LBHurtado\SMS\Drivers;

use LBHurtado\EngageSpark\EngageSpark;

class EngageSparkDriver extends Driver
{
    const RECIPIENT_TYPE = 'mobile_number';

    protected $client;

    protected $from = 'serbis.io';

    public function __construct(EngageSpark $engageSpark, $from = null)
    {
        $this->client = $engageSpark;

        $this->from = $from;
    }

    public function send()
    {
        return $this->client->send([
                'mobile_numbers'  => [$this->recipient],
                'message'         => $this->message,
                'recipient_type'  => self::RECIPIENT_TYPE,
                'sender_id'       => $this->from,
        ]);
    }

    public function client()
    {
        return $this->client;
    }

}
