<?php

namespace ElvinQulizade\Gdpr;

use ElvinQulizade\Gdpr\Enums\AnonymizationStrategy;
use ElvinQulizade\Gdpr\Models\RetentionPolicy;
use ElvinQulizade\Gdpr\Support\Anonymizer;
use ElvinQulizade\Gdpr\Support\PersonalDataExporter;
use ElvinQulizade\Gdpr\Support\RetentionRunner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Gdpr
{
    public function __construct(
        protected RetentionRunner $runner,
        protected PersonalDataExporter $exporter,
        protected Anonymizer $anonymizer,
    ) {}

    /**
     * @return Builder<RetentionPolicy>
     */
    public function policies(): Builder
    {
        return RetentionPolicy::query();
    }

    public function runner(): RetentionRunner
    {
        return $this->runner;
    }

    public function exporter(): PersonalDataExporter
    {
        return $this->exporter;
    }

    /**
     * Run all (or one) retention policies.
     *
     * @return array<string, mixed>
     */
    public function run(?int $policyId = null, bool $dryRun = false): array
    {
        return $this->runner->run($policyId, $dryRun);
    }

    /**
     * @param  array<string, string|AnonymizationStrategy>  $fields
     * @return array<int, string>
     */
    public function anonymize(Model $model, array $fields, array $values = []): array
    {
        return $this->anonymizer->anonymize($model, $fields, $values);
    }
}
