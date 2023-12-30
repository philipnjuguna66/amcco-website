<?php

namespace Appsorigin\Plots\Filament\Resources\LocationResource\Pages;

use Appsorigin\Plots\Filament\Resources\LocationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLocation extends EditRecord
{
    protected static string $resource = LocationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
