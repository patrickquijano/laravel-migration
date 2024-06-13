<?php

declare(strict_types=1);

namespace LaravelMigration\Support\Facades;

use Closure;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema as AbstractSchema;
use LaravelMigration\Database\Schema\Blueprint;

class Schema extends AbstractSchema
{
    public static function connection($name): Builder
    {
        return static::getSchemaBuilder($name);
    }

    public static function getSchemaBuilder(?string $name = null): Builder
    {
        $builder = parent::connection($name);
        $builder->blueprintResolver(static fn (string $table, ?Closure $callback) => new Blueprint($table, $callback));

        return $builder;
    }
}
