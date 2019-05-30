<?php

namespace LBHurtado\SMS\Jobs;

use LBHurtado\SMS\Events\AirtimeTransferred;
use Illuminate\Bus\Queueable;
use LBHurtado\SMS\Classes\TopupParams;
use LBHurtado\EngageSpark\EngageSpark;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TopupAmount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const MODE = 'topup';

    protected $params;

    protected $service;

    public function __construct(TopupParams $params)
    {
        $this->params = $params;
    }

    public function handle(EngageSpark $engageSpark)
    {
        $this->service = $engageSpark->send($this->params->toArray(), self::MODE);

        event(new AirtimeTransferred($this->params));
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getService()
    {
        return $this->service;
    }
}
