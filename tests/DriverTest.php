<?php

namespace LBHurtado\SMS\Tests;

use Mockery;
use Illuminate\Support\Str;
use LBHurtado\SMS\Facades\SMS;
use LBHurtado\SMS\Classes\SendParams;
use LBHurtado\SMS\Classes\TopupParams;
use LBHurtado\EngageSpark\EngageSpark;
use Illuminate\Support\Facades\Queue;
use LBHurtado\SMS\Drivers\EngageSparkDriver;
use Illuminate\Foundation\Testing\WithFaker;
use LBHurtado\SMS\Jobs\{SendMessage, TopupAmount};

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
        $org_id = $this->faker->numberBetween(1000,9999);
        $mobile_number = $this->faker->phoneNumber;
        $message = $this->faker->sentence;
        $sender_id = $this->faker->word;

        /*** act ***/
        $this->engagespark->shouldReceive('getOrgId')->once()->andReturn($org_id);
        $this->driver->to($mobile_number)->content($message)->from($sender_id)->send();

        /*** assert ***/
        Queue::assertPushed(SendMessage::class, function ($job) use ($org_id, $mobile_number, $message, $sender_id) {
//            dd(array_diff($job->getParams()->toArray(), (new SendParams($org_id, $mobile_number, $message, $sender_id))->toArray()));
            return $job->getParams()->toArray() == (new SendParams($org_id, $mobile_number, $message, $sender_id))->toArray();
            return true;
        });
    }

    /** @test */
    public function it_can_topup_an_amount()
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
            return $job->getParams()->toArray() == (new TopupParams($org_id, $mobile_number, $amount, $reference))->toArray();
        });
    }

//    /** @test */
    public function it_can_send_a_message_actual()
    {
        //change the api_key and org_id to reflect actual in order to send
        $engagespark = app(EngageSpark::class);
        $driver = new EngageSparkDriver($engagespark, 'serbis.io');
//        $driver->to('639173011987')->content('testing job 8')->send();
//        $driver->to('639166342969')->topup(15);
//        $driver->to('639166342969')->reference('12345')->topup(25);
//        $driver->to('639366760473')->from('TXTCMDR')->content('25 pesos')->send()->topup(25);
        SMS::channel('engagespark')->to('639268520749')->content('testing 123')->from('serbis.io')->send()->topup(25);
    }
}