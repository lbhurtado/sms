<?php

namespace LBHurtado\SMS\Jobs;

use Illuminate\Bus\Queueable;
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

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function handle(EngageSpark $engageSpark)
    {
        $engageSpark->send($this->params, self::MODE);
    }
}