<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NorthstarTest extends TestCase
{
    /**
     * Test that user signup data was received.
     *
     * @return void
     */
    public function testGettingUserSignupData()
    {
        $northstar = app('northstar');

        //@TODO - test with a mock user from phoenix?
        $response = $northstar->getUserSignups("55789de0a59dbf3c7a8b4575", 1690);

        $this->assertNotNull($response, 'Response is Null');
    }
}
