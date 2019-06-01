<?php

namespace LBHurtado\SMS\Tests;

use Mockery;
use Illuminate\Support\Str;
use LBHurtado\SMS\Facades\SMS;
use LBHurtado\EngageSpark\EngageSpark;
use Illuminate\Support\Facades\{Queue, Event};
use LBHurtado\SMS\Drivers\EngageSparkDriver;
use Illuminate\Foundation\Testing\WithFaker;
use LBHurtado\EngageSpark\Events\{MessageSent, AirtimeTransferred};
use LBHurtado\EngageSpark\Jobs\{SendMessage, TransferAirtime};
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
    public function driver_can_send_a_message_job_and_dispatch_event()
    {
        Queue::fake();
        Event::fake();

        /*** arrange ***/
        $mobile = $this->faker->phoneNumber;
        $message = $this->faker->sentence;
        $senderId = 'xxx'; //$this->faker->word;

        /*** act ***/
        $this->driver->to($mobile)->content($message)->from($senderId)->send();

        /*** assert ***/
        Queue::assertPushed(SendMessage::class, function ($job) use ($mobile, $message, $senderId) {
            return $job->mobile == $mobile && $job->message == $message && $job->senderId = $senderId;
        });
    
        Event::assertDispatched(MessageSent::class, function ($event) use ($mobile, $message, $senderId)  {
            return $event->mobile == $mobile && $event->message == $message && $event->senderId == $senderId;
        });
    }

    /** @test */
    public function it_can_topup_an_amount_using_a_job_and_dispatch_event()
    {
        Queue::fake();
        Event::fake();

        /*** arrange ***/
        $mobile = $this->faker->phoneNumber;
        $amount = $this->faker->numberBetween(25,100);
        $reference = Str::random(5);

        /*** act ***/
        // $this->engagespark->shouldReceive('getOrgId')->times(4);
        $this->driver->reference($reference)->to($mobile)->topup($amount);

        /*** assert ***/
        // $params = new TopupHttpApiParams($this->engagespark, $mobile, $amount, $reference);


        Queue::assertPushed(TransferAirtime::class, function ($job) use ($mobile, $amount, $reference) {
            return $job->mobile == $mobile && $job->amount == $amount && $job->reference = $reference;
        });
        Event::assertDispatched(AirtimeTransferred::class, function ($event) use ($mobile, $amount, $reference)  {
            return $event->mobile == $mobile && $event->amount == $amount && $event->reference = $reference;
        });
    }

   /** @test */
    public function it_can_send_actual_message_and_topup()
    {
        $engagespark = app(EngageSpark::class);
        $driver = new EngageSparkDriver($engagespark, 'serbis.io');
        // $driver->to('639173011987')->content('testing job 11')->send();    

//        $driver->to('639166342969')->reference('12345')->topup(25);
       $driver->to('639268520749')->from('TXTCMDR')->content('Sagot ka pag nakakuha ka ng load.')->send()->topup(25);


//        SMS::channel('engagespark')->to('639166342969')->content('testing 123')->from('serbis.io')->send()->topup(25);
    }
}
