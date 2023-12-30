<?php

namespace Appsorigin\Plots\Filament\Resources\ProjectResource\Pages;

use App\Events\BlogCreatedEvent;
use Appsorigin\Plots\Filament\Resources\ProjectResource;
use Appsorigin\Plots\Models\Project;
use Appsorigin\Plots\Models\ProjectLocation;
use Carbon\Carbon;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {

        $data['slug'] = $this->getRecord()->link?->slug;

        foreach (ProjectLocation::query()->where('project_id', $this->record->id)->get() as $location) {

            $data['location_id'][] = $location->location_id;

        }

        if ( isset($data['extra']) && (sizeof($data['extra']) > 0))
        {
            foreach ($data['extra'] as $extra)
            {
                $data['sections'][] = [
                    'type' => $extra['type'],
                    'data' => $extra['extra']
                ];
            }
        }


        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        try {


            DB::beginTransaction();
            /**
             * @var Project $record
             */
            $project = $record;

            $projectData = [
                'use_page_builder' => $data['use_page_builder'],
                'name' => $data['name'],
                'status' => $data['status'],
                'price' => $data['price'],
                'meta_title' => $data['meta_title'],
                'meta_description' => $data['meta_description'],
                'location' => $data['location'],
                'purpose' => $data['purpose'],
                'featured_image' => $data['featured_image'],
            ];

            if (! $data['use_page_builder'])
            {
                $projectData["body"] = $data['body'];
                $projectData["mutation"] = $data['mutation'];
                $projectData["amenities"] = $data['amenities'];
                $projectData["gallery"] = $data['gallery'];
                $projectData["video_path"] = $data['video_path'];
                $projectData["map"] = $data['map'];
                $projectData["cta"] = $data['cta'];
            }
            else{



                foreach ($data['sections'] as $section) {

                    $projectData['extra'][] = [
                        'type' => $section['type'],
                        'extra' => $section['data'],
                    ];

                }

            }


            $project->update($projectData);

            $record->setCreatedAt(Carbon::parse($data['created_at']));

            $record->saveQuietly();

            $record->link()->delete();

            $project->link()->create([
                'slug' => $data['slug'],
                'type' => 'project',
            ]);

            event(new BlogCreatedEvent($record));

            ProjectLocation::query()->where('project_id', $project->id)->delete();

            foreach ($data['location_id'] as $locationId) {

                ProjectLocation::create([
                    'location_id' => $locationId,
                    'project_id' => $project->id
                ]);
            }

            DB::commit();

            return $project;


        } catch (\Exception $e) {

            DB::rollBack();

            throw new \Exception($e->getMessage());
        }
    }

}
