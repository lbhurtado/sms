<?php

namespace LBHurtado\SMS\Drivers;

use Illuminate\Support\Str;
use LBHurtado\EngageSpark\EngageSpark;
use LBHurtado\EngageSpark\Events\MessageSent;
use Illuminate\Foundation\Bus\DispatchesJobs;
use LBHurtado\EngageSpark\Jobs\{SendMessage, TopupAmount};
use LBHurtado\EngageSpark\Classes\{SendHttpApiParams, TopupHttpApiParams};

class EngageSparkDriver extends Driver
{
    use DispatchesJobs;

    /** @var EngageSpark */
    protected $service;

    /** @var string */
    private $reference;

    /**
     * EngageSparkDriver constructor.
     * @param EngageSpark $service
     * @param null $from
     */
    public function __construct(EngageSpark $service, $from = null)
    {
        $this->service = $service;
        $this->sender = $from;
        $this->reference = $this->generateReference();
    }

    /**
     * @return $this|mixed
     */
    public function send()
    {
        tap(new SendHttpApiParams($this->getOrgId(), $this->recipient, $this->message, $this->sender), function ($params) {
            tap(new SendMessage($params), function ($job) {
                $this->dispatch($job);
            });
            //TODO: this is only true if sync, not if async - find a way to dispatch event once job is successful
            tap(new MessageSent($params), function ($event) {
                event($event);
            });
        });

        return $this;
    }

    /**
     * @param int $amount
     * @return $this|mixed
     */
    public function topup(int $amount)
    {
        tap(new TopupHttpApiParams($this->getOrgId(), $this->recipient, $amount, $this->reference), function ($params) {
            tap(new TopupAmount($params), function ($job) {
                $this->dispatch($job);
            });
        });

        return $this;
    }

    /**
     * @return EngageSpark
     */
    public function client()
    {
        return $this->service;
    }

    /**
     * @return string
     */
    public function getOrgId()
    {
        return $this->client()->getOrgId();
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param $reference
     * @return $this
     */
    public function reference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return string
     */
    protected function generateReference(): string
    {
        return Str::random(6);
    }
}
