<?php

declare(strict_types=1);

namespace LaravelMigration\Tests\Unit\Database\Schema;

use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use LaravelMigration\Database\Schema\Blueprint;
use LaravelMigration\Tests\Unit\TestCase as AbstractTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class BlueprintTest extends AbstractTestCase
{
    public static function tableNamesProvider(): array
    {
        return [
            [fake()->word().'.'.fake()->word()],
            [fake()->word()],
        ];
    }

    #[DataProvider('tableNamesProvider')]
    public function test_date_time_method_returns_a_date_time_column_with_6_precision(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $columnName = fake()->word();
        $expectedColumn = new ColumnDefinition([
            'type' => 'dateTime',
            'name' => $columnName,
            'precision' => 6,
        ]);
        // Act
        $actualColumn = $blueprint->dateTime($columnName);
        // Assert
        $this->assertEquals($expectedColumn, $actualColumn);
    }

    #[DataProvider('tableNamesProvider')]
    public function test_date_time_tz_method_returns_a_date_time_tz_column_with_6_precision(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $columnName = fake()->word();
        $expectedColumn = new ColumnDefinition([
            'type' => 'dateTimeTz',
            'name' => $columnName,
            'precision' => 6,
        ]);
        // Act
        $actualColumn = $blueprint->dateTimeTz($columnName);
        // Assert
        $this->assertEquals($expectedColumn, $actualColumn);
    }

    #[DataProvider('tableNamesProvider')]
    public function test_datetimes_method_returns_a_2_nullable_date_time_columns_with_6_precision(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $expectedColumns = [
            new ColumnDefinition([
                'type' => 'dateTime',
                'name' => 'created_at',
                'precision' => 6,
                'nullable' => true,
            ]),
            new ColumnDefinition([
                'type' => 'dateTime',
                'name' => 'updated_at',
                'precision' => 6,
                'nullable' => true,
            ]),
        ];
        // Act
        $blueprint->datetimes();
        // Assert
        $this->assertEquals($expectedColumns, $blueprint->getColumns());
    }

    #[DataProvider('tableNamesProvider')]
    public function test_nullable_numeric_morphs_method_a_returns_2_nullable_columns_with_string_and_big_integer_types_and_2_indexes(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $columnName = fake()->word();
        $expectedColumns = [
            new ColumnDefinition([
                'type' => 'string',
                'name' => $columnName.'_type',
                'length' => 255,
                'nullable' => true,
            ]),
            new ColumnDefinition([
                'type' => 'bigInteger',
                'name' => $columnName.'_id',
                'autoIncrement' => false,
                'unsigned' => true,
                'nullable' => true,
            ]),
        ];
        $expectedCommands = array_merge(
            $expectedColumns,
            [
                new Fluent([
                    'name' => 'index',
                    'index' => 'ix_'.$tableName.'_'.$columnName.'_type_'.$columnName.'_id',
                    'columns' => [
                        $columnName.'_type',
                        $columnName.'_id',
                    ],
                    'algorithm' => null,
                ]),
                new Fluent([
                    'name' => 'index',
                    'index' => 'ix_'.$tableName.'_'.$columnName.'_id_'.$columnName.'_type',
                    'columns' => [
                        $columnName.'_id',
                        $columnName.'_type',
                    ],
                    'algorithm' => null,
                ]),
            ]
        );
        // Act
        $blueprint->nullableNumericMorphs($columnName);
        // Assert
        $this->assertEquals($expectedColumns, $blueprint->getColumns());
        $this->assertEquals($expectedCommands, $blueprint->getCommands());
    }

    #[DataProvider('tableNamesProvider')]
    public function test_nullable_ulid_morphs_method_a_returns_2_nullable_columns_with_string_types_and_2_indexes(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $columnName = fake()->word();
        $expectedColumns = [
            new ColumnDefinition([
                'type' => 'string',
                'name' => $columnName.'_type',
                'length' => 255,
                'nullable' => true,
            ]),
            new ColumnDefinition([
                'type' => 'char',
                'name' => $columnName.'_id',
                'length' => 26,
                'nullable' => true,
            ]),
        ];
        $expectedCommands = array_merge(
            $expectedColumns,
            [
                new Fluent([
                    'name' => 'index',
                    'index' => 'ix_'.$tableName.'_'.$columnName.'_type_'.$columnName.'_id',
                    'columns' => [
                        $columnName.'_type',
                        $columnName.'_id',
                    ],
                    'algorithm' => null,
                ]),
                new Fluent([
                    'name' => 'index',
                    'index' => 'ix_'.$tableName.'_'.$columnName.'_id_'.$columnName.'_type',
                    'columns' => [
                        $columnName.'_id',
                        $columnName.'_type',
                    ],
                    'algorithm' => null,
                ]),
            ]
        );
        // Act
        $blueprint->nullableUlidMorphs($columnName);
        // Assert
        $this->assertEquals($expectedColumns, $blueprint->getColumns());
        $this->assertEquals($expectedCommands, $blueprint->getCommands());
    }

    #[DataProvider('tableNamesProvider')]
    public function test_nullable_uuid_morphs_method_a_returns_2_nullable_columns_with_string_types_and_2_indexes(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $columnName = fake()->word();
        $expectedColumns = [
            new ColumnDefinition([
                'type' => 'string',
                'name' => $columnName.'_type',
                'length' => 255,
                'nullable' => true,
            ]),
            new ColumnDefinition([
                'type' => 'uuid',
                'name' => $columnName.'_id',
                'nullable' => true,
            ]),
        ];
        $expectedCommands = array_merge(
            $expectedColumns,
            [
                new Fluent([
                    'name' => 'index',
                    'index' => 'ix_'.$tableName.'_'.$columnName.'_type_'.$columnName.'_id',
                    'columns' => [
                        $columnName.'_type',
                        $columnName.'_id',
                    ],
                    'algorithm' => null,
                ]),
                new Fluent([
                    'name' => 'index',
                    'index' => 'ix_'.$tableName.'_'.$columnName.'_id_'.$columnName.'_type',
                    'columns' => [
                        $columnName.'_id',
                        $columnName.'_type',
                    ],
                    'algorithm' => null,
                ]),
            ]
        );
        // Act
        $blueprint->nullableUuidMorphs($columnName);
        // Assert
        $this->assertEquals($expectedColumns, $blueprint->getColumns());
        $this->assertEquals($expectedCommands, $blueprint->getCommands());
    }

    #[DataProvider('tableNamesProvider')]
    public function test_numeric_morphs_method_returns_a_2_non_nullable_columns_with_string_and_big_integer_types_and_2_indexes(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $columnName = fake()->word();
        $expectedColumns = [
            new ColumnDefinition([
                'type' => 'string',
                'name' => $columnName.'_type',
                'length' => 255,
            ]),
            new ColumnDefinition([
                'type' => 'bigInteger',
                'name' => $columnName.'_id',
                'autoIncrement' => false,
                'unsigned' => true,
            ]),
        ];
        $expectedCommands = array_merge(
            $expectedColumns,
            [
                new Fluent([
                    'name' => 'index',
                    'index' => 'ix_'.$tableName.'_'.$columnName.'_type_'.$columnName.'_id',
                    'columns' => [
                        $columnName.'_type',
                        $columnName.'_id',
                    ],
                    'algorithm' => null,
                ]),
                new Fluent([
                    'name' => 'index',
                    'index' => 'ix_'.$tableName.'_'.$columnName.'_id_'.$columnName.'_type',
                    'columns' => [
                        $columnName.'_id',
                        $columnName.'_type',
                    ],
                    'algorithm' => null,
                ]),
            ]
        );
        // Act
        $blueprint->numericMorphs($columnName);
        // Assert
        $this->assertEquals($expectedColumns, $blueprint->getColumns());
        $this->assertEquals($expectedCommands, $blueprint->getCommands());
    }

    #[DataProvider('tableNamesProvider')]
    public function test_soft_deletes_datetime_method_returns_a_nullable_date_time_column_with_6_precision(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $expectedColumn = new ColumnDefinition([
            'type' => 'dateTime',
            'name' => 'deleted_at',
            'precision' => 6,
            'nullable' => true,
        ]);
        // Act
        $actualColumn = $blueprint->softDeletesDatetime();
        // Assert
        $this->assertEquals($expectedColumn, $actualColumn);
    }

    #[DataProvider('tableNamesProvider')]
    public function test_soft_deletes_method_returns_a_nullable_timestamp_column_with_6_precision(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $expectedColumn = new ColumnDefinition([
            'type' => 'timestamp',
            'name' => 'deleted_at',
            'precision' => 6,
            'nullable' => true,
        ]);
        // Act
        $actualColumn = $blueprint->softDeletes();
        // Assert
        $this->assertEquals($expectedColumn, $actualColumn);
    }

    #[DataProvider('tableNamesProvider')]
    public function test_soft_deletes_tz_method_returns_a_nullable_timestamp_tz_column_with_6_precision(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $expectedColumn = new ColumnDefinition([
            'type' => 'timestampTz',
            'name' => 'deleted_at',
            'precision' => 6,
            'nullable' => true,
        ]);
        // Act
        $actualColumn = $blueprint->softDeletesTz();
        // Assert
        $this->assertEquals($expectedColumn, $actualColumn);
    }

    #[DataProvider('tableNamesProvider')]
    public function test_time_method_returns_a_time_column_with_6_precision(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $columnName = fake()->word();
        $expectedColumn = new ColumnDefinition([
            'type' => 'time',
            'name' => $columnName,
            'precision' => 6,
        ]);
        // Act
        $actualColumn = $blueprint->time($columnName);
        // Assert
        $this->assertEquals($expectedColumn, $actualColumn);
    }

    #[DataProvider('tableNamesProvider')]
    public function test_time_tz_method_returns_a_time_tz_column_with_6_precision(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $columnName = fake()->word();
        $expectedColumn = new ColumnDefinition([
            'type' => 'timeTz',
            'name' => $columnName,
            'precision' => 6,
        ]);
        // Act
        $actualColumn = $blueprint->timeTz($columnName);
        // Assert
        $this->assertEquals($expectedColumn, $actualColumn);
    }

    #[DataProvider('tableNamesProvider')]
    public function test_timestamp_method_returns_a_timestamp_column_with_6_precision(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $columnName = fake()->word();
        $expectedColumn = new ColumnDefinition([
            'type' => 'timestamp',
            'name' => $columnName,
            'precision' => 6,
        ]);
        // Act
        $actualColumn = $blueprint->timestamp($columnName);
        // Assert
        $this->assertEquals($expectedColumn, $actualColumn);
    }

    #[DataProvider('tableNamesProvider')]
    public function test_timestamp_tz_method_returns_a_timestamp_tz_column_with_6_precision(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $columnName = fake()->word();
        $expectedColumn = new ColumnDefinition([
            'type' => 'timestampTz',
            'name' => $columnName,
            'precision' => 6,
        ]);
        // Act
        $actualColumn = $blueprint->timestampTz($columnName);
        // Assert
        $this->assertEquals($expectedColumn, $actualColumn);
    }

    #[DataProvider('tableNamesProvider')]
    public function test_timestamps_method_returns_a_2_nullable_timestamp_columns_with_6_precision(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $expectedColumns = [
            new ColumnDefinition([
                'type' => 'timestamp',
                'name' => 'created_at',
                'precision' => 6,
                'nullable' => true,
            ]),
            new ColumnDefinition([
                'type' => 'timestamp',
                'name' => 'updated_at',
                'precision' => 6,
                'nullable' => true,
            ]),
        ];
        // Act
        $blueprint->timestamps();
        // Assert
        $this->assertEquals($expectedColumns, $blueprint->getColumns());
    }

    #[DataProvider('tableNamesProvider')]
    public function test_timestamps_tz_method_returns_a_2_nullable_timestamp_tz_columns_with_6_precision(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $expectedColumns = [
            new ColumnDefinition([
                'type' => 'timestampTz',
                'name' => 'created_at',
                'precision' => 6,
                'nullable' => true,
            ]),
            new ColumnDefinition([
                'type' => 'timestampTz',
                'name' => 'updated_at',
                'precision' => 6,
                'nullable' => true,
            ]),
        ];
        // Act
        $blueprint->timestampsTz();
        // Assert
        $this->assertEquals($expectedColumns, $blueprint->getColumns());
    }

    #[DataProvider('tableNamesProvider')]
    public function test_ulid_id_method_returns_a_char_primary_column(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $expectedColumn = new ColumnDefinition([
            'type' => 'char',
            'name' => 'id',
            'length' => 26,
            'primary' => true,
        ]);
        // Act
        $actualColumn = $blueprint->ulidId();
        // Assert
        $this->assertEquals($expectedColumn, $actualColumn);
    }

    #[DataProvider('tableNamesProvider')]
    public function test_ulid_morphs_method_returns_a_2_non_nullable_columns_with_string_and_char_type_and_2_indexes(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $columnName = fake()->word();
        $expectedColumns = [
            new ColumnDefinition([
                'type' => 'string',
                'name' => $columnName.'_type',
                'length' => 255,
            ]),
            new ColumnDefinition([
                'type' => 'char',
                'name' => $columnName.'_id',
                'length' => 26,
            ]),
        ];
        $expectedCommands = array_merge(
            $expectedColumns,
            [
                new Fluent([
                    'name' => 'index',
                    'index' => 'ix_'.$tableName.'_'.$columnName.'_type_'.$columnName.'_id',
                    'columns' => [
                        $columnName.'_type',
                        $columnName.'_id',
                    ],
                    'algorithm' => null,
                ]),
                new Fluent([
                    'name' => 'index',
                    'index' => 'ix_'.$tableName.'_'.$columnName.'_id_'.$columnName.'_type',
                    'columns' => [
                        $columnName.'_id',
                        $columnName.'_type',
                    ],
                    'algorithm' => null,
                ]),
            ]
        );
        // Act
        $blueprint->ulidMorphs($columnName);
        // Assert
        $this->assertEquals($expectedColumns, $blueprint->getColumns());
        $this->assertEquals($expectedCommands, $blueprint->getCommands());
    }

    #[DataProvider('tableNamesProvider')]
    public function test_uuid_id_method_returns_a_char_primary_column(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $expectedColumn = new ColumnDefinition([
            'type' => 'uuid',
            'name' => 'id',
            'primary' => true,
        ]);
        // Act
        $actualColumn = $blueprint->uuidId();
        // Assert
        $this->assertEquals($expectedColumn, $actualColumn);
    }

    #[DataProvider('tableNamesProvider')]
    public function test_uuid_morphs_method_returns_a_2_non_nullable_columns_with_string_and_uuid_and_2_indexes(string $tableName): void
    {
        // Arrange
        $blueprint = new Blueprint($tableName);
        $tableName = Str::replace('.', '_', $tableName);
        $columnName = fake()->word();
        $expectedColumns = [
            new ColumnDefinition([
                'type' => 'string',
                'name' => $columnName.'_type',
                'length' => 255,
            ]),
            new ColumnDefinition([
                'type' => 'uuid',
                'name' => $columnName.'_id',
            ]),
        ];
        $expectedCommands = array_merge(
            $expectedColumns,
            [
                new Fluent([
                    'name' => 'index',
                    'index' => 'ix_'.$tableName.'_'.$columnName.'_type_'.$columnName.'_id',
                    'columns' => [
                        $columnName.'_type',
                        $columnName.'_id',
                    ],
                    'algorithm' => null,
                ]),
                new Fluent([
                    'name' => 'index',
                    'index' => 'ix_'.$tableName.'_'.$columnName.'_id_'.$columnName.'_type',
                    'columns' => [
                        $columnName.'_id',
                        $columnName.'_type',
                    ],
                    'algorithm' => null,
                ]),
            ]
        );
        // Act
        $blueprint->uuidMorphs($columnName);
        // Assert
        $this->assertEquals($expectedColumns, $blueprint->getColumns());
        $this->assertEquals($expectedCommands, $blueprint->getCommands());
    }
}
