<?php

namespace LBHurtado\SMS\Drivers;

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

    //TODO: orgnaization_id - expose it
    public function send()
    {
        return $this->client->send([
                'mobile_numbers'  => [$this->recipient],
                'message'         => $this->message,
                'recipient_type'  => self::RECIPIENT_TYPE,
                'sender_id'       => $this->sender,
        ]);
    }

    public function client()
    {
        return $this->client;
    }

}
