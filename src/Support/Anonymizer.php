<?php

namespace ElvinQulizade\Gdpr\Support;

use ElvinQulizade\Gdpr\Enums\AnonymizationStrategy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Anonymizer
{
    public function __construct(
        protected bool $allowUniqueOverwrite = false,
    ) {}

    public function allowUniqueOverwrite(bool $allow = true): static
    {
        $this->allowUniqueOverwrite = $allow;

        return $this;
    }

    /**
     * Anonymize the given fields on a model and persist the changes.
     *
     * @param  array<string, string|AnonymizationStrategy>  $fields  field => strategy
     * @param  array<string, mixed>  $values  static replacement values
     * @return array<int, string> list of changed column names
     */
    public function anonymize(Model $model, array $fields, array $values = []): array
    {
        $changed = [];

        foreach ($fields as $field => $strategy) {
            if ($this->isProtected($model, $field)) {
                continue;
            }

            $original = $model->getOriginal($field) ?? $model->{$field};
            $replacement = $this->replacement($strategy, $original, $values[$field] ?? null);

            if ((string) $replacement === (string) $original) {
                continue;
            }

            $model->{$field} = $replacement;
            $changed[] = $field;
        }

        if ($changed !== []) {
            $model->save();
        }

        return array_values(array_unique($changed));
    }

    protected function isProtected(Model $model, string $field): bool
    {
        if ($model->getKeyName() === $field) {
            return true;
        }

        $deletedAtColumn = method_exists($model, 'getDeletedAtColumn')
            ? $model->getDeletedAtColumn()
            : null;

        $protected = array_filter([
            $model->getCreatedAtColumn(),
            $model->getUpdatedAtColumn(),
            $deletedAtColumn,
            'password',
        ]);

        if (in_array($field, $protected, true)) {
            return true;
        }

        if ($this->allowUniqueOverwrite) {
            return false;
        }

        foreach ($this->uniqueIndexes($model) as $index) {
            if (in_array($field, $index['columns'], true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array<int, array{columns: array<int, string>}>
     */
    protected function uniqueIndexes(Model $model): array
    {
        $schema = $model->getConnection()->getSchemaBuilder();

        try {
            return collect($schema->getIndexes($model->getTable()))
                ->filter(fn (array $index): bool => $index['unique'] || $index['primary'])
                ->values()
                ->all();
        } catch (\Throwable) {
            return [];
        }
    }

    protected function replacement(string | AnonymizationStrategy $strategy, mixed $original, mixed $customValue): mixed
    {
        $strategy = $strategy instanceof AnonymizationStrategy
            ? $strategy
            : (AnonymizationStrategy::tryFrom((string) $strategy) ?? AnonymizationStrategy::Random);

        return match ($strategy) {
            AnonymizationStrategy::Null => null,
            AnonymizationStrategy::Random => Str::random(16),
            AnonymizationStrategy::Mask => $this->mask($original),
            AnonymizationStrategy::Static => $customValue ?? __('filament-gdpr::gdpr.anonymization.static_placeholder'),
        };
    }

    protected function mask(mixed $value): string
    {
        if ($value === null || ! is_scalar($value) || $value === '') {
            return '***';
        }

        $value = (string) $value;

        if (str_contains($value, '@')) {
            [$local, $domain] = explode('@', $value, 2);

            return substr($local, 0, 1) . '***@' . $domain;
        }

        if (strlen($value) <= 2) {
            return str_repeat('*', strlen($value));
        }

        return substr($value, 0, 2) . '***';
    }
}
