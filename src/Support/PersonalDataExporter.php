<?php

namespace ElvinQulizade\Gdpr\Support;

use ElvinQulizade\Gdpr\Enums\ExportStatus;
use ElvinQulizade\Gdpr\Models\PersonalDataExport;
use Illuminate\Support\Facades\Storage;
use Throwable;

class PersonalDataExporter
{
    public function __construct(
        protected string $disk = 'local',
    ) {}

    public function disk(string $disk): static
    {
        $this->disk = $disk;

        return $this;
    }

    public function export(string $dataSubject): PersonalDataExport
    {
        $export = PersonalDataExport::create([
            'data_subject' => $dataSubject,
            'status' => ExportStatus::Processing,
            'disk' => $this->disk,
        ]);

        try {
            $payload = $this->gather($dataSubject);
            $path = $this->write($export->id, $payload);

            $export->update([
                'status' => ExportStatus::Completed,
                'path' => $path,
                'size' => Storage::disk($this->disk)->size($path),
                'completed_at' => now(),
            ]);
        } catch (Throwable $e) {
            $export->update([
                'status' => ExportStatus::Failed,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }

        return $export->refresh();
    }

    /**
     * @return array<string, array<int, array<string, mixed>>>
     */
    protected function gather(string $dataSubject): array
    {
        $identifier = config('filament-gdpr.user_identifier', 'email');
        $results = [];

        foreach (config('filament-gdpr.models', []) as $model => $config) {
            $options = is_array($config) ? $config : ['column' => $config];
            $column = $options['column'] ?? $identifier;

            $records = (new $model)->newQuery()
                ->where($column, $dataSubject)
                ->limit(1000)
                ->get()
                ->map(fn ($record): array => $record->toArray())
                ->all();

            $results[class_basename($model)] = $records;
        }

        return $results;
    }

    /**
     * @param  array<string, array<int, array<string, mixed>>>  $payload
     */
    protected function write(int $exportId, array $payload): string
    {
        $prefix = rtrim(config('filament-gdpr.export_prefix', 'filament-gdpr-exports'), '/');
        $location = "{$prefix}/{$exportId}";
        $tmpDir = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . "gdpr-export-{$exportId}";

        if (! is_dir($tmpDir)) {
            mkdir($tmpDir, 0755, true);
        }

        $jsonPath = $tmpDir . DIRECTORY_SEPARATOR . 'data.json';
        $htmlPath = $tmpDir . DIRECTORY_SEPARATOR . 'index.html';
        $zipPath = $tmpDir . '.zip';

        file_put_contents($jsonPath, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        file_put_contents($htmlPath, $this->renderHtml($payload));

        $zip = new \ZipArchive;
        $zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $zip->addFile($jsonPath, 'data.json');
        $zip->addFile($htmlPath, 'index.html');
        $zip->close();

        $storedPath = "{$location}/{$exportId}.zip";
        Storage::disk($this->disk)->put($storedPath, file_get_contents($zipPath));

        @unlink($jsonPath);
        @unlink($htmlPath);
        @unlink($zipPath);
        @rmdir($tmpDir);

        return $storedPath;
    }

    /**
     * @param  array<string, array<int, array<string, mixed>>>  $payload
     */
    protected function renderHtml(array $payload): string
    {
        $rows = '';

        foreach ($payload as $model => $records) {
            $sections = '';
            foreach ($records as $record) {
                $fields = '';
                foreach ($record as $key => $value) {
                    $value = is_scalar($value) ? (string) $value : json_encode($value);
                    $fields .= "<tr><th>{$key}</th><td>{$value}</td></tr>";
                }
                $sections .= "<table><tbody>{$fields}</tbody></table>";
            }
            $rows .= "<h2>{$model}</h2>{$sections}";
        }

        $stamp = now()->toDateTimeString();

        return <<<HTML
        <!doctype html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Personal data export</title>
            <style>
                body { font-family: system-ui, sans-serif; margin: 2rem; }
                table { border-collapse: collapse; margin-bottom: 1.5rem; width: 100%; }
                th, td { border: 1px solid #e2e8f0; padding: .5rem; text-align: left; }
                th { background: #f8fafc; }
            </style>
        </head>
        <body>
        <h1>Personal data export</h1>
        <p>Generated: {$stamp}</p>
        {$rows}
        </body>
        </html>
        HTML;
    }
}
