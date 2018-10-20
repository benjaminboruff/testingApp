<?php

namespace Tests\Feature;

use App\Expression;

// use Tests\TestCase;
// use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use \PHPUnit\Framework\TestCase;

class ExpressionTest extends TestCase
{

    /** @test */
    public function it_finds_a_string()
    {
        $regexp = Expression::make()->find('www');

        $this->assertRegExp($regexp, 'www');

        $regexp2 = Expression::make()->then('www');

        $this->assertRegExp($regexp2, 'www');
    }

    /** @test */
    public function it_checks_for_anything()
    {
        $regexp = Expression::make()->anything();
        $this->assertRegExp($regexp, 'foo');
    }

    /** @test */
    public function it_maybe_has_a_value()
    {
        $regexp = Expression::make()->maybe('http');
        $this->assertRegExp($regexp, 'http');
        $this->assertRegExp($regexp, '');
    }

    /** @test */
    public function it_can_chain_method_calls()
    {
        $regexp = Expression::make()->find('www')->maybe('.')->then('boruff');
        $this->assertRegExp($regexp, 'www.boruff');
        $this->assertNotRegExp($regexp, 'wwwXboruff');
    }

    /** @test */
    public function it_can_exclude_values()
    {
        $regexp = Expression::make()
            ->find('www')
            ->anythingBut('bar')
            ->then('baz');
        $this->assertRegExp($regexp, 'wwwfoobaz');
        $this->assertNotRegExp($regexp, 'wwwbarbaz');
    }
}
