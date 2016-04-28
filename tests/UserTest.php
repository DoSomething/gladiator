<?php

use Gladiator\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends TestCase
{
    protected $repository;

    /**
     * Test to retrieve an existing contestant user in the database.
     *
     * @return void
     * @test
     */
    public function itCanStoreANewContestant()
    {
        $account = (object) [
            'id' => str_random(24),
        ];

        $repository = app(\Gladiator\Repositories\UserRepositoryContract::class);
        $user = $repository->create($account);

        $this->assertTrue($user instanceof User);

        $this->seeInDatabase('users', [
            'id' => $account->id,
            'role' => null,
        ]);
    }


    /**
     * Test to retrieve an existing contestant user in the database.
     *
     * @return void
     * @test
     */
    public function itRetrievesAnExistingContestantUserByNorthstarId()
    {
        $model = factory(User::class)->create();

        $mock = $this->mock(\Gladiator\Services\Northstar\Northstar::class)
            ->shouldReceive('getUser')
            ->andReturn((object) [
                'id' => $model->id,
                'first_name' => 'Larry',
                // ...
            ]);

        $repository = app(\Gladiator\Repositories\UserRepositoryContract::class);
        $user = $repository->find($model->id);


        $this->assertEquals($model->id, $user->id);
        $this->assertEquals($model->role, $user->role);
        $this->assertEquals('Larry', $user->first_name);
    }

    /**
     * Test to retrieve an existing contestant user in the database.
     *
     * @return void
     * @test
     */
    public function itRetrievesAnExistingAdminUserByNorthstarId()
    {
        $account = (object) [
            'id' => str_random(24),
            'role' => 'admin',
        ];

        $repository = app(\Gladiator\Repositories\UserRepositoryContract::class);
        $repository->create($account);

        $this->seeInDatabase('users', [
            'id' => $account->id,
            'role' => 'admin',
        ]);
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
