<?php

namespace Tests\Feature;

use Illuminate\Auth\GenericUser;
use Tests\TestCase;

/**
 * Base test
 */
abstract class BaseTest extends TestCase
{
    /**
     * If true, setup has run at least once.
     * @var boolean
     */
    protected static $setUpHasRunOnce = false;

    /**
     * Setup tests
     */
    public function setUp(): void
    {
        parent::setUp();

        if (!static::$setUpHasRunOnce) {
            $this->artisan('migrate:fresh');
            $this->artisan('db:seed');
            static::$setUpHasRunOnce = true;
        }
    }

    /**
     * Acting as regular user
     * @return BaseTest
     */
    public function actingAsUser()
    {
        $user = new GenericUser(['id' => 2]);

        return $this->actingAs($user);
    }

    /**
     * Acting as administrator
     * @return BaseTest
     */
    public function actingAsAdministrator()
    {
        $admin = new GenericUser(['id' => 1]);

        return $this->actingAs($admin);
    }
}
