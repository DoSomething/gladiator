<?php

use Gladiator\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * A Faker generator instance
     *
     * @var \Faker\Generator
     */
    protected $faker;


    public function setUp()
    {
        parent::setUp();

        // Get a new Faker generator from Laravel.
        $this->faker = app(\Faker\Generator::class);
    }

    /**
     * Set the currently logged in user to be a "fake" administrator.
     *
     * @return $this
     */
    public function asAdminUser()
    {
        $admin = new User();
        $admin->id = str_random(24);
        $admin->role = 'admin';

        $this->be($admin);

        return $this;
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Mock a class, and register with the IoC container.
     *
     * @param  $class  string  Class name to mock
     * @return \Mockery\MockInterface
     */
    public function mock($class)
    {
        $mock = Mockery::mock($class);

        $this->app->instance($class, $mock);

        return $mock;
    }
}
