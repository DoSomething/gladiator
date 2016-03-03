<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Gladiator\Services\Phoenix\Phoenix;

class PhoenixTest extends TestCase
{
    /**
     * Test that user signup data was received.
     *
     * @return void
     */
    public function testGettingUserSignupData()
    {
        $phoenix = new Phoenix();

        //@TODO - test with a real user from the DB?
        $response = $phoenix->getUserSignupData('2137661');

        $this->assertNotNull($response, 'Response is Null');
    }
}
