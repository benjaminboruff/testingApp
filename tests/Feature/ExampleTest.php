<?php

namespace Tests\Feature;

use Tests\BrowserKitTestCase;

//use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends BrowserKitTestCase
{
    use MailTracking;

    public function setUp()
    {
        parent::setUp();
        $this->setUpMailTracking();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        // $response = $this->get('/');

        // $response->assertStatus(200);
        $this->visit('/')
            ->seeEmailWasSent();
    }
}
