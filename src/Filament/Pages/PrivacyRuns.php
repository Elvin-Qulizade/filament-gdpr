<?php

namespace ElvinQulizade\Gdpr\Filament\Pages;

use ElvinQulizade\Gdpr\Enums\PrivacyRunStatus;
use ElvinQulizade\Gdpr\Filament\Widgets\DataPrivacyStatsWidget;
use ElvinQulizade\Gdpr\Models\PrivacyRunLog;
use ElvinQulizade\Gdpr\Support\RetentionRunner;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class PrivacyRuns extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament-gdpr::pages.privacy-runs';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-clock';

    protected static string | \UnitEnum | null $navigationGroup = null;

    protected static ?string $navigationLabel = null;

    public function getTitle(): string | Htmlable
    {
        return __('filament-gdpr::gdpr.runs.title');
    }

    public static function getNavigationLabel(): string
    {
        return __(static::$navigationLabel ?? 'filament-gdpr::gdpr.runs.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return static::$navigationGroup ?? config('filament-gdpr.navigation_group') ?? __('filament-gdpr::gdpr.plugin.navigation_group');
    }

    protected function table(Table $table): Table
    {
        return $table
            ->query(PrivacyRunLog::query()->latest('id'))
            ->columns([
                TextColumn::make('policy.name')
                    ->label(__('filament-gdpr::gdpr.fields.policy'))
                    ->badge()
                    ->formatStateUsing(fn (PrivacyRunLog $record): string => $record->policy !== null ? $record->policy->name : '—'),

                TextColumn::make('status')
                    ->label(__('filament-gdpr::gdpr.fields.status'))
                    ->badge()
                    ->color(fn (PrivacyRunStatus $state): string => $state->color())
                    ->formatStateUsing(fn (PrivacyRunStatus $state): string => $state->label()),

                TextColumn::make('records_processed')
                    ->label(__('filament-gdpr::gdpr.fields.records_processed'))
                    ->numeric()
                    ->sortable(),

                TextColumn::make('records_deleted')
                    ->label(__('filament-gdpr::gdpr.fields.records_deleted'))
                    ->numeric()
                    ->sortable()
                    ->color('danger'),

                TextColumn::make('records_anonymized')
                    ->label(__('filament-gdpr::gdpr.fields.records_anonymized'))
                    ->numeric()
                    ->sortable()
                    ->color('info'),

                TextColumn::make('started_at')
                    ->label(__('filament-gdpr::gdpr.fields.started_at'))
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('finished_at')
                    ->label(__('filament-gdpr::gdpr.fields.finished_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('error')
                    ->label(__('filament-gdpr::gdpr.fields.error'))
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(collect(PrivacyRunStatus::cases())->mapWithKeys(fn ($status) => [$status->value => $status->label()])),
            ])
            ->actions([
                Action::make('retry')
                    ->label(__('filament-gdpr::gdpr.runs.retry'))
                    ->icon('heroicon-o-arrow-path')
                    ->requiresConfirmation()
                    ->action(function (PrivacyRunLog $record): void {
                        if ($record->retention_policy_id !== null) {
                            app(RetentionRunner::class)->run($record->retention_policy_id);
                        }

                        Notification::make()
                            ->title(__('filament-gdpr::gdpr.runs.success'))
                            ->success()
                            ->send();
                    })
                    ->hidden(fn (PrivacyRunLog $record): bool => $record->status !== PrivacyRunStatus::Failed || $record->retention_policy_id === null),
            ])
            ->defaultSort('id', 'desc');
    }

    public function getHeaderWidgets(): array
    {
        return [DataPrivacyStatsWidget::class];
    }

    public function getHeaderWidgetsColumns(): int | array
    {
        return 4;
    }
}
