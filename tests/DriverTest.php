<?php

namespace LBHurtado\SMS\Tests;

use Mockery;
use Illuminate\Support\Str;
use LBHurtado\SMS\Facades\SMS;
use LBHurtado\EngageSpark\EngageSpark;
use Illuminate\Support\Facades\{Queue, Event};
use LBHurtado\SMS\Drivers\EngageSparkDriver;
use Illuminate\Foundation\Testing\WithFaker;
use LBHurtado\EngageSpark\Events\MessageSent;
use LBHurtado\EngageSpark\Jobs\{SendMessage, TopupAmount};
use LBHurtado\EngageSpark\Classes\{SendHttpApiParams, TopupHttpApiParams};

class DriverTest extends TestCase
{
    use WithFaker;

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
        /*** arrange ***/
        Queue::fake();
        Event::fake();

        $org_id = $this->faker->numberBetween(1000,9999);
        $mobile_number = $this->faker->phoneNumber;
        $message = $this->faker->sentence;
        $sender_id = $this->faker->word;
        $params = new SendHttpApiParams($org_id, $mobile_number, $message, $sender_id);

        /*** act ***/
        $this->engagespark->shouldReceive('getOrgId')->once()->andReturn($org_id);
        $this->driver->to($mobile_number)->content($message)->from($sender_id)->send();

        /*** assert ***/
        Queue::assertPushed(SendMessage::class, function ($job) use ($params) {
            return $job->params->toArray() == $params->toArray();
        });
        Event::assertDispatched(MessageSent::class, function ($event) use ($params)  {
            return $event->params->toArray() == $params->toArray();
        });
    }

    /** @test */
    public function it_can_topup_an_amount_using_a_job()
    {
        /*** arrange ***/
        Queue::fake();

        $org_id = $this->faker->numberBetween(1000,9999);
        $mobile_number = $this->faker->phoneNumber;
        $amount = $this->faker->numberBetween(25,100);
        $reference = Str::random(5);

        /*** act ***/
        $this->engagespark->shouldReceive('getOrgId')->once()->andReturn($org_id);
        $this->driver->reference($reference)->to($mobile_number)->topup($amount);

        /*** assert ***/
        Queue::assertPushed(TopupAmount::class, function ($job) use ($org_id, $mobile_number, $amount, $reference) {
            return $job->params->toArray() == (new TopupHttpApiParams($org_id, $mobile_number, $amount, $reference))->toArray();
        });

    }

//    /** @test */
    public function it_can_send_event_upon_topup()
    {

    }

//    /** @test */
    public function it_can_send_a_message_actual()
    {
        //change the api_key and org_id to reflect actual in order to send
        $engagespark = app(EngageSpark::class);


        $this->engagespark->shouldReceive('getOrgId')->once()->andReturn($org_id);

        $driver = new EngageSparkDriver($engagespark, 'serbis.io');
//        $driver->to('639173011987')->content('testing job 8')->send();

//        $driver->to('639166342969')->reference('12345')->topup(25);
//        $driver->to('639366760473')->from('TXTCMDR')->content('25 pesos')->send()->topup(25);


//        SMS::channel('engagespark')->to('639166342969')->content('testing 123')->from('serbis.io')->send()->topup(25);
    }
}
