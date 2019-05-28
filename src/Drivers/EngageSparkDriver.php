<?php

namespace LBHurtado\SMS\Drivers;

use Illuminate\Support\Str;
use LBHurtado\EngageSpark\EngageSpark;
use Illuminate\Foundation\Bus\DispatchesJobs;
use LBHurtado\SMS\Jobs\{SendMessage, TopupAmount};
use LBHurtado\SMS\Classes\{SendParams, TopupParams};

class EngageSparkDriver extends Driver
{
    use DispatchesJobs;

    const RECIPIENT_TYPE = 'mobile_number';

    protected $client;

    private $reference;

    public function __construct(EngageSpark $engageSpark, $from = null)
    {
        $this->client = $engageSpark;
        $this->sender = $from;
        $this->reference = Str::random(6);
    }

    public function send()
    {
        tap(new SendParams($this->getOrgId(), $this->recipient, $this->message, $this->sender), function ($params) {
            tap(new SendMessage($params), function ($job) {
                $this->dispatch($job);
            });
        });

        return $this;
    }

    public function topup(int $amount)
    {
        tap(new TopupParams($this->getOrgId(), $this->recipient, $amount, $this->reference), function ($params) {
            tap(new TopupAmount($params), function ($job) {
                $this->dispatch($job);
            });
        });

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

    public function getReference()
    {
        return $this->reference;
    }

    public function reference($reference)
    {
        $this->reference = $reference;

        return $this;
    }
}
