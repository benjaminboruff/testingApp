<?php

namespace Tests\Feature;

use Tests\TestCase;
// use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Mail;

class EmailTest extends TestCase
{
    use MailTracking;

    public function setUp()
    {
        parent::setUp();
        $this->setUpMailTracking();
    }

    /** @test */
    public function it_should_be_verified_as_sent_after_sending()
    {
        Mail::raw('Hello world', function ($message) {
            $message->to('foo@bar.com');
            $message->from('bar@foo.com');
        });

        Mail::raw('Hello world', function ($message) {
            $message->to('foo@bar.com');
            $message->from('bar@foo.com');
        });
        
        $this->seeEmailWasSent()
            ->seeNumberOfEmailsSent(2)
            ->seeEmailTo('foo@bar.com');
    }
}
