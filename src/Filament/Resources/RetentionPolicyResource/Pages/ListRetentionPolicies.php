<?php

namespace ElvinQulizade\Gdpr\Filament\Resources\RetentionPolicyResource\Pages;

use ElvinQulizade\Gdpr\Filament\Resources\RetentionPolicyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRetentionPolicies extends ListRecords
{
    protected static string $resource = RetentionPolicyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
