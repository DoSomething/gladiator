<?php

use Gladiator\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends TestCase
{
    protected $repository;


    public function setUp()
    {
        parent::setUp();

        // $this->repository = app(\Gladiator\Repositories\UserRepositoryContract::class);
    }

    /**
     * Test to retrieve an existing user in the database.
     *
     * @return void
     * @test
     */
    public function itRetrievesAnExistingUserByNorthstarId()
    {
        // dd(get_class($this->repository));

        // $user = User::create()

        // dd($user);

        $this->assertTrue(true);
    }

    /**
     * Test to retrieve an existing user in the database.
     *
     * @return void
     * @test
     */
    // public function testUserIsInWaitingRoom()
    // {
        // $this->json('POST', 'api/v1/users',
        //     ['id' => 'fantini-loves-impact@dosomething.org',
        //      'term', => 'email',
        //      'campaign_id' => '1',
        //      'campaign_run_id' => '2'
        //     ]);

        // $this->assertTrue(true);
    // }

    /**
     * Test to see if our api returns json.
     *
     * @return void
     * @test
     */
    public function testUserApiReturnsResponse()
    {
        $this->json('GET', 'api/v1/users')
             ->assertResponseStatus('200');
    }

    /**
     * Test to see if the api returns valid users.
     *
     * @return void
     * @test
     */
    public function testUserApiReturnsUsers()
    {
        $users = factory(User::class, 2)->create();
        $this->json('GET', 'api/v1/users')
             ->seeJsonStructure(['*' => [
                     'id', 'created_at', 'updated_at', 'role',
                 ]]);
    }
}
