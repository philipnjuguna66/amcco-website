<?php

namespace App\Filament\Resources\WhatsappResource\Pages;

use App\Filament\Resources\WhatsappResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateWhatsapp extends CreateRecord
{
    protected static string $resource = WhatsappResource::class;

    protected function handleRecordCreation(array $data): Model
    {

        return parent::handleRecordCreation($data);
    }
}
