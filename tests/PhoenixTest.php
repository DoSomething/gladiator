<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Gladiator\Services\Phoenix\Phoenix;
use Gladiator\Models\User;
use Gladiator\Services\Northstar\Exceptions\NorthstarUserNotFoundException;

class PhoenixTest extends TestCase
{
    /**
     * Test that user signup data was received.
     *
     * @return void
     */
    public function testGettingUserSignupData()
    {
        $phoenix = app('phoenix');

        //@TODO - test with a mock user from phoenix?
        $response = $phoenix->getUserSignupData('1702694', '1173');

        $this->assertNotNull($response, 'Response is Null');
    }
}
