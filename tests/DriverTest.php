<?php

namespace LBHurtado\SMS\Tests;

use Mockery;
use LBHurtado\SMS\Facades\SMS;
use LBHurtado\EngageSpark\EngageSpark;
use LBHurtado\SMS\Drivers\EngageSparkDriver;

class DriverTest extends TestCase
{
    /** @var Mockery\Mock */
    protected $engagespark;

    /** @var \LBHurtado\SMS\Drivers\EngageSparkDriver */
    protected $driver;

    public function setUp(): void
    {
        parent::setUp();

        $this->engagespark = Mockery::mock(EngageSpark::class);
        $this->driver = new EngageSparkDriver($this->engagespark);
    }

    public function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    /** @test */
    public function it_can_send_a_message()
    {
        $this->engagespark->shouldReceive('getOrgId')->once()->andReturn(1234);
        $this->engagespark->shouldReceive('send')->once();
        $this->driver->to('639173011987')->content('test')->from('TXTCMDR')->send();

        $this->assertTrue(true);
    }

    /** @test */
    public function it_can_topup_an_amount()
    {
        $this->engagespark->shouldReceive('getOrgId')->once();
        $this->engagespark->shouldReceive('send')->once();
        $this->driver->to('639173011987')->from('TXTCMDR')->topup(25);

        $this->assertTrue(true);
    }

//    /** @test */
    public function it_can_send_a_message_actual()
    {
        //change the api_key and org_id to reflect actual in order to send
        $engagespark = app(EngageSpark::class);
        $driver = new EngageSparkDriver($engagespark, 'serbis.io');
        $driver->to('639173011987')->content('testing job 2')->send();
//        $driver->to('639166342969')->topup(40);
//        $driver->to('639166342969')->content('25 pesoses')->send()->topup(25); //TODO: async - make this a queued job
//        SMS::channel('engagespark')->to('639173011987')->content('from facade with sender id')->from('TXTCMDR')->send();
    }
}