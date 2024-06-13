# Laravel Migration

This Laravel package provides enhanced functionality for managing database migrations. It extends the core ```Blueprint``` class and ```Schema``` facade to streamline your migration experience.

## Features

- **Standardized Time Precision:** Ensures all time-related database types (like ```datetime``` and ```timestamp```) utilize a precision of 6 by default (instead of the default 0).
- **Automatic Morph Indexing:** Automatically adds indexes to all columns created using morph relationships (```morphTo```, ```morphMany```, etc.) for improved performance in queries.

## Installation

```bash
composer require patrickquijano/laravel-migration
```

## Usage

To leverage this package in your existing migrations, simply rename the following classes:
1. Replace ```Illuminate\Database\Schema\Blueprint``` with ```LaravelMigration\Database\Schema\Blueprint```
2. Replace ```Illuminate\Support\Facades\Schema``` with ```LaravelMigration\Support\Facades\Schema```

**Example (Before):**

```php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamp('email_verified_at')->nullable();
        // ...
    });
}
```

**Example (After):**

```php
use LaravelMigration\Database\Schema\Blueprint;
use LaravelMigration\Support\Facades\Schema;

public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamp('email_verified_at')->nullable();
        // ...
    });
}
```

## Publish Stub Files (Optional)

For convenience, you can publish stub files with the updated imports for your future migrations:

```bash
php artisan vendor:publish --tag=laravel-migration-stubs
```

This will create new stub files within your ```stubs``` directory, reflecting the package's classes.

## Benefits

- Improved Code Consistency: Enforces a standardized time precision for temporal database types.
- Enhanced Performance: Automatic indexing on morph relationships leads to faster queries.
- Streamlined Development: Stub file publishing simplifies migration creation with pre-configured imports.

We encourage you to utilize this package to streamline your Laravel migration development and ensure optimal database performance.
