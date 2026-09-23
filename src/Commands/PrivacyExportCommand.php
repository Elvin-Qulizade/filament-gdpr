<?php

namespace ElvinQulizade\Gdpr\Commands;

use ElvinQulizade\Gdpr\Support\PersonalDataExporter;
use Illuminate\Console\Command;

class PrivacyExportCommand extends Command
{
    public $signature = 'privacy:export
        {email : The data subject identifier to export}';

    public $description = 'Generate a personal data export (right to access)';

    public function handle(PersonalDataExporter $exporter): int
    {
        $this->components->task('Gathering personal data', function () use ($exporter) {
            $export = $exporter->export($this->argument('email'));

            $this->components->info(sprintf(
                'Export completed: %s (%s)',
                $export->path,
                $export->size !== null ? number_format($export->size) . ' bytes' : '0 bytes',
            ));
        });

        return self::SUCCESS;
    }
}
