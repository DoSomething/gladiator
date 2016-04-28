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
}
