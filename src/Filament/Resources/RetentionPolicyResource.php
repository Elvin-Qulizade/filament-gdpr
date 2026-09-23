<?php

namespace ElvinQulizade\Gdpr\Filament\Resources;

use ElvinQulizade\Gdpr\Enums\AnonymizationStrategy;
use ElvinQulizade\Gdpr\Enums\RetentionAction;
use ElvinQulizade\Gdpr\Enums\RetentionPeriodUnit;
use ElvinQulizade\Gdpr\Facades\Gdpr;
use ElvinQulizade\Gdpr\Filament\Resources\RetentionPolicyResource\Pages;
use ElvinQulizade\Gdpr\Models\RetentionPolicy;
use ElvinQulizade\Gdpr\Support\ModelDiscovery;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class RetentionPolicyResource extends Resource
{
    protected static ?string $model = RetentionPolicy::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shield-check';

    protected static string | \UnitEnum | null $navigationGroup = null;

    protected static ?string $navigationLabel = null;

    public static function getNavigationLabel(): string
    {
        return __(static::$navigationLabel ?? 'filament-gdpr::gdpr.policy.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return static::$navigationGroup ?? config('filament-gdpr.navigation_group') ?? __('filament-gdpr::gdpr.plugin.navigation_group');
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function getModelLabel(): string
    {
        return __('filament-gdpr::gdpr.policy.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-gdpr::gdpr.policy.plural_label');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label(__('filament-gdpr::gdpr.fields.name'))
                    ->required()
                    ->maxLength(255),

                Select::make('model_class')
                    ->label(__('filament-gdpr::gdpr.fields.model_class'))
                    ->options(ModelDiscovery::models())
                    ->required()
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(fn (Set $set) => $set('retention_column', 'created_at')),

                Select::make('retention_column')
                    ->label(__('filament-gdpr::gdpr.fields.retention_column'))
                    ->options(fn (Get $get): array => ModelDiscovery::columns((string) $get('model_class')))
                    ->default('created_at')
                    ->required()
                    ->live(),

                TextInput::make('retention_period')
                    ->label(__('filament-gdpr::gdpr.fields.retention_period'))
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->default(12)
                    ->columnSpan(1),

                Select::make('period_unit')
                    ->label(__('filament-gdpr::gdpr.fields.period_unit'))
                    ->options(collect(RetentionPeriodUnit::cases())->mapWithKeys(fn ($unit) => [$unit->value => $unit->label()]))
                    ->default(RetentionPeriodUnit::Months->value)
                    ->required()
                    ->columnSpan(1),

                Select::make('action')
                    ->label(__('filament-gdpr::gdpr.fields.action'))
                    ->options(collect(RetentionAction::cases())->mapWithKeys(fn ($action) => [$action->value => $action->label()]))
                    ->default(RetentionAction::Anonymize->value)
                    ->live()
                    ->required()
                    ->columnSpan(2),

                Repeater::make('anonymize_fields')
                    ->label(__('filament-gdpr::gdpr.fields.anonymize_fields'))
                    ->defaultItems(1)
                    ->schema([
                        Select::make('field')
                            ->options(fn (Get $get): array => ModelDiscovery::anonymizableColumns((string) $get('../../model_class')))
                            ->searchable()
                            ->required(),

                        Select::make('strategy')
                            ->options(collect(AnonymizationStrategy::cases())->mapWithKeys(fn ($strategy) => [$strategy->value => $strategy->label()]))
                            ->default(config('filament-gdpr.default_strategy', 'mask'))
                            ->required(),
                    ])
                    ->columns(2)
                    ->hidden(fn (Get $get): bool => $get('action') !== RetentionAction::Anonymize->value),

                Repeater::make('anonymize_values')
                    ->label(__('filament-gdpr::gdpr.fields.anonymize_values'))
                    ->defaultItems(0)
                    ->schema([
                        Select::make('field')
                            ->options(fn (Get $get): array => ModelDiscovery::anonymizableColumns((string) $get('../../model_class')))
                            ->searchable()
                            ->required(),

                        TextInput::make('value')
                            ->label(__('filament-gdpr::gdpr.fields.anonymize_values') . ' — value')
                            ->required(),
                    ])
                    ->columns(2)
                    ->hidden(fn (Get $get): bool => $get('action') !== RetentionAction::Anonymize->value),

                Toggle::make('enabled')
                    ->label(__('filament-gdpr::gdpr.fields.enabled'))
                    ->default(true),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament-gdpr::gdpr.fields.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('model_class')
                    ->label(__('filament-gdpr::gdpr.fields.model_class'))
                    ->badge()
                    ->searchable(),

                TextColumn::make('action')
                    ->label(__('filament-gdpr::gdpr.fields.action'))
                    ->badge()
                    ->formatStateUsing(fn (RetentionAction $state): string => $state->label())
                    ->color(fn (RetentionAction $state): string => $state === RetentionAction::Delete ? 'danger' : 'info'),

                TextColumn::make('retention_period')
                    ->label(__('filament-gdpr::gdpr.fields.retention_period'))
                    ->sortable()
                    ->formatStateUsing(fn (string $state, RetentionPolicy $record): string => $record->displayPeriod()),

                IconColumn::make('enabled')
                    ->label(__('filament-gdpr::gdpr.fields.enabled'))
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('filament-gdpr::gdpr.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                Action::make('run')
                    ->label(__('filament-gdpr::gdpr.runs.retry'))
                    ->icon('heroicon-o-play')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->action(fn (RetentionPolicy $record) => static::runPolicy($record)),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    Action::make('runSelected')
                        ->label(__('filament-gdpr::gdpr.runs.retry_failed'))
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            foreach ($records as $record) {
                                static::runPolicy($record);
                            }
                        }),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function runPolicy(RetentionPolicy $record): void
    {
        Gdpr::run($record->id);

        Notification::make()
            ->title(__('filament-gdpr::gdpr.runs.success'))
            ->success()
            ->send();
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRetentionPolicies::route('/'),
            'create' => Pages\CreateRetentionPolicy::route('/create'),
            'edit' => Pages\EditRetentionPolicy::route('/{record}/edit'),
        ];
    }
}
