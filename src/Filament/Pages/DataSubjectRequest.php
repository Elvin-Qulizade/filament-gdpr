<?php

namespace ElvinQulizade\Gdpr\Filament\Pages;

use ElvinQulizade\Gdpr\Enums\ExportStatus;
use ElvinQulizade\Gdpr\Models\PersonalDataExport;
use ElvinQulizade\Gdpr\Support\PersonalDataExporter;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DataSubjectRequest extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament-gdpr::pages.data-subject-request';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-arrow-down';

    protected static string | \UnitEnum | null $navigationGroup = null;

    protected static ?string $navigationLabel = null;

    public string $dataSubject = '';

    public function getTitle(): string | Htmlable
    {
        return __('filament-gdpr::gdpr.dsar.title');
    }

    public static function getNavigationLabel(): string
    {
        return __(static::$navigationLabel ?? 'filament-gdpr::gdpr.dsar.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return static::$navigationGroup ?? config('filament-gdpr.navigation_group') ?? __('filament-gdpr::gdpr.plugin.navigation_group');
    }

    public function generate(): void
    {
        $this->validate([
            'dataSubject' => ['required', 'email'],
        ]);

        try {
            app(PersonalDataExporter::class)->export($this->dataSubject);

            Notification::make()
                ->title(__('filament-gdpr::gdpr.dsar.success'))
                ->success()
                ->send();
        } catch (\Throwable $e) {
            Notification::make()
                ->title($e->getMessage())
                ->danger()
                ->send();
        }
    }

    protected function table(Table $table): Table
    {
        return $table
            ->query(PersonalDataExport::query()->latest('id'))
            ->columns([
                TextColumn::make('data_subject')
                    ->label(__('filament-gdpr::gdpr.fields.data_subject'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label(__('filament-gdpr::gdpr.fields.status'))
                    ->badge()
                    ->color(fn (ExportStatus $state): string => $state->color())
                    ->formatStateUsing(fn (ExportStatus $state): string => $state->label()),

                TextColumn::make('size')
                    ->label(__('filament-gdpr::gdpr.fields.size'))
                    ->formatStateUsing(fn (int $state): string => number_format($state) . ' bytes')
                    ->sortable(),

                TextColumn::make('completed_at')
                    ->label(__('filament-gdpr::gdpr.fields.finished_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('error')
                    ->label(__('filament-gdpr::gdpr.fields.error'))
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([])
            ->defaultSort('id', 'desc');
    }

    public function download(PersonalDataExport $record): StreamedResponse
    {
        return Storage::disk($record->disk ?? config('filament-gdpr.disk'))
            ->download($record->path);
    }
}
