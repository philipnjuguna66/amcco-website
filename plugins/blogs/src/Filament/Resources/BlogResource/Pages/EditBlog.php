<?php

namespace Appsorigin\Blog\Filament\Resources\BlogResource\Pages;

use App\Events\BlogCreatedEvent;
use Appsorigin\Blog\Filament\Resources\BlogResource;
use Appsorigin\Plots\Models\Blog;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditBlog extends EditRecord
{
    protected static string $resource = BlogResource::class;

    protected function getActions(): array
    {
        return [
           // Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {

        $data['slug'] = $this->getRecord()->link?->slug;

        return $data;

    }

        protected function handleRecordUpdate(Model $record, array $data): Model
        {
        /** @var Blog $record */

        return DB::transaction(function () use ($record, $data) {
            $record->update([
                'title' => $data['title'],
                'body' => $data['body'],
                'is_published' => $data['is_published'],
                'canonical' => $data['canonical'],
                'meta_title' => $data['meta_title'],
                'meta_description' => $data['meta_description'],
                'featured_image' => $data['featured_image'],
            ]);

            $record->link()->delete();

            $record->link()->create([
                'type' => 'post',
                'slug' => str($data['slug'])->slug()->value(),
            ]);

            event(new BlogCreatedEvent($record));

            return $record;

        });
    }
}
