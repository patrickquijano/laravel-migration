<?php

declare(strict_types=1);

namespace LaravelMigration\Database\Schema;

use Illuminate\Database\Schema\Blueprint as AbstractBlueprint;

class Blueprint extends AbstractBlueprint
{
    public function dateTime($column, $precision = 6)
    {
        return parent::dateTime($column, $precision);
    }

    public function datetimes($precision = 6)
    {
        parent::datetimes($precision);
    }

    public function dateTimeTz($column, $precision = 6)
    {
        return parent::dateTimeTz($column, $precision);
    }

    public function nullableNumericMorphs($name, $indexName = null)
    {
        parent::nullableNumericMorphs($name, $indexName);
        $this->index(["{$name}_id", "{$name}_type"]);
    }

    public function nullableUlidMorphs($name, $indexName = null)
    {
        parent::nullableUlidMorphs($name, $indexName);
        $this->index(["{$name}_id", "{$name}_type"]);
    }

    public function nullableUuidMorphs($name, $indexName = null)
    {
        parent::nullableUuidMorphs($name, $indexName);
        $this->index(["{$name}_id", "{$name}_type"]);
    }

    public function numericMorphs($name, $indexName = null)
    {
        parent::numericMorphs($name, $indexName);
        $this->index(["{$name}_id", "{$name}_type"]);
    }

    public function softDeletes($column = 'deleted_at', $precision = 6)
    {
        return parent::softDeletes($column, $precision);
    }

    public function softDeletesDatetime($column = 'deleted_at', $precision = 6)
    {
        return parent::softDeletesDatetime($column, $precision);
    }

    public function softDeletesTz($column = 'deleted_at', $precision = 6)
    {
        return parent::softDeletesTz($column, $precision);
    }

    public function time($column, $precision = 6)
    {
        return parent::time($column, $precision);
    }

    public function timestamp($column, $precision = 6)
    {
        return parent::timestamp($column, $precision);
    }

    public function timestamps($precision = 6)
    {
        parent::timestamps($precision);
    }

    public function timestampsTz($precision = 6)
    {
        parent::timestampsTz($precision);
    }

    public function timestampTz($column, $precision = 6)
    {
        return parent::timestampTz($column, $precision);
    }

    public function timeTz($column, $precision = 6)
    {
        return parent::timeTz($column, $precision);
    }

    public function ulidId($column = 'id')
    {
        return parent::ulid($column)->primary();
    }

    public function ulidMorphs($name, $indexName = null)
    {
        parent::ulidMorphs($name, $indexName);
        $this->index(["{$name}_id", "{$name}_type"]);
    }

    public function uuidId($column = 'id')
    {
        return parent::uuid($column)->primary();
    }

    public function uuidMorphs($name, $indexName = null)
    {
        parent::uuidMorphs($name, $indexName);
        $this->index(["{$name}_id", "{$name}_type"]);
    }

    protected function createIndexName($type, array $columns)
    {
        $types = [
            'primary' => 'pk',
            'unique' => 'ak',
            'index' => 'ix',
            'fulltext' => 'ft',
            'spatialIndex' => 'gi',
            'foreign' => 'fk',
        ];
        $table = str_contains($this->table, '.')
            ? substr_replace($this->table, '.'.$this->prefix, strrpos($this->table, '.'), 1)
            : $this->prefix.$this->table;
        $index = strtolower($types[$type].'_'.$table.'_'.implode('_', $columns));

        return substr(str_replace(['-', '.'], '_', $index), 0, 64);
    }
}
