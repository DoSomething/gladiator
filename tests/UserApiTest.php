<?php

use Gladiator\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserApiTest extends TestCase
{
    /**
     * Test for valid response.
     *
     * @return void
     */
    public function testUserApiReturnsResponse()
    {
        // @TODO - test the updated /users endpoint properly.
        return true;
        // $this->json('GET', 'api/v1/users')
        //      ->assertResponseStatus('200');
    }

    /**
     * Test for retrieving valid users.
     *
     * @return void
     */
    public function testUserApiReturnsUsers()
    {
        // @TODO - test the updated /users endpoint properly.
        return true;
        // $users = factory(User::class, 2)->create();

        // $this->json('GET', 'api/v1/users')
        //      ->seeJsonStructure([
        //         '*' => [
        //             'northstar_id', 'created_at', 'updated_at', 'role',
        //         ]
        //     ]);
    }
}
