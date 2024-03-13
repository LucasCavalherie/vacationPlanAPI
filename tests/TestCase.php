<?php

namespace Tests;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    protected function tearDown(): void
    {
        $this->artisan('migrate:reset');
        parent::tearDown();
    }
}
