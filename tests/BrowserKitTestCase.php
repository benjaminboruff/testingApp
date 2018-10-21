<?php

namespace Tests;

use App\User;

// use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class BrowserKitTestCase extends BaseTestCase
{
    use CreatesApplication;

    public $baseUrl = 'http://localhost';
    protected $user;

    public function signIn($user = null)
    {
        if (! $user) {
            // and a user
            $user = factory(User::class)->create();
        }

        $this->user = $user;

        // that is logged in
        $this->actingAs($this->user);

        return $this;
    }
}
