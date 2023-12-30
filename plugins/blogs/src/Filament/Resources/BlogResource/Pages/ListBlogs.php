<?php

namespace Appsorigin\Blog\Filament\Resources\BlogResource\Pages;

use Appsorigin\Blog\Filament\Resources\BlogResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListBlogs extends ListRecords
{
    protected static string $resource = BlogResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->latest();
    }
}
