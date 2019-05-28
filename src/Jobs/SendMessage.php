<?php

namespace LBHurtado\SMS\Jobs;

use Illuminate\Bus\Queueable;
use LBHurtado\SMS\Classes\SendParams;
use LBHurtado\EngageSpark\EngageSpark;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const MODE = 'sms';

    protected $params;

    protected $service;

    public function __construct(SendParams $params)
    {
        $this->params = $params;
    }

    public function handle(EngageSpark $engageSpark)
    {
        $this->service = $engageSpark->send($this->params->toArray(), self::MODE);
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