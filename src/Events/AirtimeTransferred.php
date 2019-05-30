<?php

namespace LBHurtado\SMS\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use LBHurtado\SMS\Classes\TopupParams;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class AirtimeTransferred
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var TopupParams */
    protected $params;

    /**
     * Create a new event instance.
     *
     * @param TopupParams $params
     */
    public function __construct(TopupParams $params)
    {
        $this->params = $params;
    }

    /**
     * @return TopupParams
     */
    public function getParams(): TopupParams
    {
        return $this->params;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}