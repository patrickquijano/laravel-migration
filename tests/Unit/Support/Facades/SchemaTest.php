<?php

declare(strict_types=1);

namespace Unit\Support\Facades;

use Illuminate\Database\Schema\Builder;
use LaravelMigration\Support\Facades\Schema;
use LaravelMigration\Tests\Unit\TestCase as AbstractTestCase;

class SchemaTest extends AbstractTestCase
{
    public function test_connection_method_returns_a_builder_instance(): void
    {
        // Arrange
        // Act
        $actual = Schema::connection(null);
        // Assert
        $this->assertInstanceOf(Builder::class, $actual);
    }

    public function test_get_schema_builder_method_returns_a_builder_instance(): void
    {
        // Arrange
        // Act
        $actual = Schema::getSchemaBuilder();
        // Assert
        $this->assertInstanceOf(Builder::class, $actual);
    }
}
