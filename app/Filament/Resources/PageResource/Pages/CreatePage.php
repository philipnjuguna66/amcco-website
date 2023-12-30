<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Events\PageCreatedEvent;
use App\Filament\Resources\PageResource;
use App\Models\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    public function mount(): void
    {
        parent::mount();

        $this->dispatchBrowserEvent('builder-collapse', true);
    }

    /**
     * @throws \Exception
     */
    protected function handleRecordCreation(array $data): Model
    {

        try {

            DB::beginTransaction();

            $data = $this->form->getState();

            /** @var Page $page */
            $page = Page::create([
                'title' => $data['title'],
                'meta_title' => $data['meta_title'],
                'meta_description' => $data['meta_description'],
                'is_published' => true,
                'is_front_page' => ($data['is_front_page']),
                'published_at' => now(),
            ]);

            $page->link()->create([
                'slug' => $data['slug'],
                'type' => 'page',
            ]);

            foreach ($data['sections'] as $section) {

                $page->sections()->create([
                    'type' => $section['type'],
                    'extra' => $section['data'],
                ]);

            }

            DB::commit();

            event(new PageCreatedEvent($page));

           return $page;

        } catch (Halt $exception) {
            DB::rollBack();

            throw new \Exception(
                $exception->getMessage()
            );
        }


    }
}
