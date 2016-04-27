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
}
