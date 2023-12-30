<?php

namespace Appsorigin\Leads\Filament\Resources\LeadResource\Pages;

use Appsorigin\Leads\Filament\Resources\LeadResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;

class ManageLeads extends ManageRecords
{
    protected static string $resource = LeadResource::class;

    protected function getActions(): array
    {
        return [
           // Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->latest();
    }
}
