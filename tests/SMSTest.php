<?php

namespace LBHurtado\SMS\Tests;

use LBHurtado\SMS\SMSManager;

class SMSTest extends TestCase
{
    /** @test */
    public function service_has_default_properties()
    {
        tap(app(SMSManager::class), function ($service) {
            $this->assertEquals('engagespark', $service->getDefaultDriver());
            $this->assertSame(config('sms.engagespark.end_points.sms'), $service->driver('engagespark')->getEndPoint('sms'));
            $this->assertSame(config('sms.engagespark.end_points.topup'), $service->driver('engagespark')->getEndPoint('topup'));
            $this->assertSame(config('sms.engagespark.sender_id'), $service->driver('engagespark')->getSenderId());
        });
    }
}
