<?php

declare(strict_types=1);

namespace LaravelMigration\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider as AbstractServiceProvider;
use LaravelMigration\Support\Facades\Schema;

class LaravelMigrationServiceProvider extends AbstractServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([__DIR__.'/../stubs' => base_path('stubs')], 'laravel-migration-stubs');
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('db.schema', fn (Application $app) => Schema::getSchemaBuilder());
    }
}
