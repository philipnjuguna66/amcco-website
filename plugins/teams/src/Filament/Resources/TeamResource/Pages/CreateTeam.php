<?php

namespace Appsorigin\Teams\Filament\Resources\TeamResource\Pages;

use App\Events\BlogCreatedEvent;
use Appsorigin\Blog\Filament\Resources\BlogResource;
use Appsorigin\Plots\Models\Blog;
use Appsorigin\Teams\Filament\Resources\TeamResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateTeam extends CreateRecord
{
    protected static string $resource = TeamResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['category']);


        return $data;
    }

    protected function afterCreate()
    {

        event(new BlogCreatedEvent($this->record));

        $data = $this->form->getState();


        $this->record->teamCategories()->attach($data['category']);

        $this->record->link()->create([
            'slug' => str($this->record->name)->slug(),
            'type' => 'post',
        ]);

    }

}
