<?php

namespace Appsorigin\Teams\Filament\Resources\TeamResource\Pages;

use App\Events\BlogCreatedEvent;
use Appsorigin\Teams\Filament\Resources\TeamResource;
use Appsorigin\Teams\Models\CompanyTeam;
use Carbon\Carbon;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditTeam extends EditRecord
{
    protected static string $resource = TeamResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }


    protected function mutateFormDataBeforeFill(array $data): array
    {

        $data['category'] = $this->record->teamCategories->pluck('id')->toArray();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['category']);


        return $data;
    }
    protected function afterSave()
    {

        $data = $this->form->getState();

        /** @var CompanyTeam $companyTeam */

        $companyTeam = $this->record;

        $companyTeam->setCreatedAt(Carbon::parse($data['created_at']));

        $companyTeam->saveQuietly();



        $companyTeam->teamCategories()->detach($data['category']);

        $companyTeam->teamCategories()->attach($data['category']);


        $this->record->link()?->delete();

        $this->record->link()->create([
            'slug' => str($this->record->name)->slug(),
            'type' => 'post',
        ]);

        event(new BlogCreatedEvent($this->record));

    }


}
