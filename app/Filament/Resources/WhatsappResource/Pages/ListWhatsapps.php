<?php

namespace App\Filament\Resources\WhatsappResource\Pages;

use App\Filament\Resources\WhatsappResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWhatsapps extends ListRecords
{
    protected static string $resource = WhatsappResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
