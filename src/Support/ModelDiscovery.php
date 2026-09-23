<?php

namespace ElvinQulizade\Gdpr\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ModelDiscovery
{
    /**
     * @return array<class-string, class-string>
     */
    public static function models(): array
    {
        $discovered = Model::getModels();

        $exclude = config('filament-gdpr.model_discovery.exclude', []);

        return collect($discovered)
            ->reject(fn (string $model): bool => in_array($model, $exclude, true))
            ->sort()
            ->mapWithKeys(fn (string $model): array => [$model => $model])
            ->all();
    }

    /**
     * @return array<int, string>
     */
    public static function columns(string $modelClass): array
    {
        try {
            $table = (new $modelClass)->getTable();

            return Schema::getColumnListing($table);
        } catch (\Throwable) {
            return [];
        }
    }

    /**
     * Columns available for anonymization (everything except primary key and timestamps).
     *
     * @return array<string, string>
     */
    public static function anonymizableColumns(string $modelClass): array
    {
        $model = new $modelClass;
        $protected = [
            $model->getKeyName(),
            $model->getCreatedAtColumn(),
            $model->getUpdatedAtColumn(),
            'deleted_at',
        ];

        return collect(self::columns($modelClass))
            ->reject(fn (string $column): bool => in_array($column, array_filter($protected), true))
            ->mapWithKeys(fn (string $column): array => [$column => $column])
            ->all();
    }
}
