<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Events\PageCreatedEvent;
use App\Filament\Resources\PageResource;
use App\Models\Page;
use App\Models\PageSection;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

   public function mount($record): void
   {
       parent::mount($record);

       $this->dispatchBrowserEvent('builder-collapse', ['data.sections', 'isCollapsed' => true]);

   }

    protected function mutateFormDataBeforeFill(array $data): array
    {

       // dd($data);



        $data['slug'] = $this->getRecord()->link?->slug;

        $sections = PageSection::query()->wherePageId($data['id'])->get();
        //$data['sections'] = $sections;

        foreach ($sections as $section) {
            $extra = [];

            foreach ($section->extra as $key => $extraData) {

                $extra[$key] = $extraData;

            }
            $data['sections'][] = [
                'type' => $section->type->value,
                'data' => $extra,
            ];
           // dd($section);

        }

        //dd($data);

     //   $data['sections'] =

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        try {

            DB::beginTransaction();

            /** @var Page $page */
            $page = $this->getRecord();

            $this->getRecord()->update([
                'title' => $data['title'],
                'meta_title' => $data['meta_title'],
                'meta_description' => $data['meta_description'],
                'is_front_page' => ($data['is_front_page']),
                'is_published' => true,
                'published_at' => now(),
            ]);

            $page->link()->delete();

            $page->link()->create([
                'slug' => $data['slug'],
                'type' => 'page',
            ]);

            $page->sections()->delete();

            foreach ($data['sections'] as $section) {

                $page->sections()->create([
                    'type' => $section['type'],
                    'extra' => $section['data'],
                ]);

            }

            DB::commit();


            event(new PageCreatedEvent($page));

            return  $page;

        } catch (Halt $exception) {
            DB::rollBack();

           throw new \Exception($exception->getMessage());
        }
    }



    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
