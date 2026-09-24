<?php

namespace ElvinQulizade\Gdpr\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use ReflectionClass;

class ModelDiscovery
{
    /**
     * @return array<class-string, class-string>
     */
    public static function models(): array
    {
        $models = [];

        foreach (static::directories() as $directory) {
            if (! is_dir($directory)) {
                continue;
            }

            foreach (File::allFiles($directory) as $file) {
                if ($file->getExtension() !== 'php') {
                    continue;
                }

                $class = static::classFromPath($file->getPathname());

                if ($class === null || ! class_exists($class)) {
                    continue;
                }

                $reflection = new ReflectionClass($class);
                if ($reflection->isAbstract() || $reflection->isInterface() || ! $reflection->isSubclassOf(Model::class)) {
                    continue;
                }

                $models[] = $class;
            }
        }

        $models = array_merge((array) config('filament-gdpr.models', []), $models);

        $exclude = config('filament-gdpr.model_discovery.exclude', []);

        return collect($models)
            ->reject(fn (string $model): bool => in_array($model, $exclude, true))
            ->unique()
            ->sort()
            ->mapWithKeys(fn (string $model): array => [$model => $model])
            ->all();
    }

    /**
     * @return array<int, string>
     */
    protected static function directories(): array
    {
        return [
            app_path('Models'),
            app_path(),
        ];
    }

    protected static function classFromPath(string $path): ?string
    {
        if (Str::startsWith($path, app_path('Models') . DIRECTORY_SEPARATOR)) {
            $relative = Str::after($path, app_path('Models') . DIRECTORY_SEPARATOR);
        } elseif (Str::startsWith($path, app_path() . DIRECTORY_SEPARATOR)) {
            $relative = Str::after($path, app_path() . DIRECTORY_SEPARATOR);
        } else {
            return null;
        }

        $class = str_replace('.php', '', $relative);
        $class = trim(str_replace(['/', '\\'], '\\', $class), '\\');

        return app()->getNamespace() . $class;
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
        if (! class_exists($modelClass)) {
            return [];
        }

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
