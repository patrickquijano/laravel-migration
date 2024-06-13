<?php

declare(strict_types=1);

namespace LaravelMigration\Tests\Unit;

use Orchestra\Testbench\TestCase as AbstractTestCase;

abstract class TestCase extends AbstractTestCase
{
    /**
     * Automatically enables package discoveries.
     *
     * @var bool
     */
    protected $enablesPackageDiscoveries = true;
}
