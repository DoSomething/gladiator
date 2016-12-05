<?php

use Gladiator\Models\User;
use Gladiator\Services\Northstar\Northstar;
use Gladiator\Repositories\UserRepositoryContract;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends TestCase
{
    /**
     * Test for storing a new contestant user in database using repository.
     *
     * @return void
     */
    public function testStoreNewUserUsingRepository()
    {
        $account = (object) [
            'northstar_id' => str_random(24),
        ];

        $repository = app(UserRepositoryContract::class);
        $user = $repository->create($account);

        $this->assertTrue($user instanceof User);

        $this->seeInDatabase('users', [
            'northstar_id' => $account->northstar_id,
            'role' => null,
        ]);
    }


    /**
     * Test to find and retrieve an existing user in the database via
     * their Northstar ID using repository.
     *
     * @return void
     */
    public function testFindUserByNorthstarIdUsingRepository()
    {
        $model = factory(User::class)->create();

        $mock = $this->mock(Northstar::class)
            ->shouldReceive('getUser')
            ->andReturn((object) [
                'northstar_id' => $model->northstar_id,
                'first_name' => 'Kallark',
                // ...
            ]);

        $repository = app(UserRepositoryContract::class);

        $user = $repository->find($model->northstar_id);

        $this->assertEquals($model->northstar_id, $user->northstar_id);
        $this->assertEquals($model->role, $user->role);
        $this->assertEquals('Kallark', $user->first_name);
    }
}
