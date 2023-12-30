<?php

namespace App\Filament\Resources\WhatsappResource\Pages;

use App\Filament\Resources\WhatsappResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWhatsapp extends EditRecord
{
    protected static string $resource = WhatsappResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
