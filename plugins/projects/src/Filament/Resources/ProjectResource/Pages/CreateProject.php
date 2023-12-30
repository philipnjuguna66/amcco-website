<?php

namespace Appsorigin\Plots\Filament\Resources\ProjectResource\Pages;

use App\Events\BlogCreatedEvent;
use Appsorigin\Plots\Filament\Resources\ProjectResource;
use Appsorigin\Plots\Models\Project;
use Appsorigin\Plots\Models\ProjectLocation;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    public function handleRecordCreation(array $data): Model
    {
        try {

            DB::beginTransaction();

            $data = $this->form->getState();

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

            $project = Project::create($projectData);

            $project->link()->create([
                'slug' => $data['slug'],
                'type' => 'project',
            ]);


            foreach ($data['location_id'] as $locationId) {

                ProjectLocation::create([
                    'location_id' => $locationId,
                    'project_id' => $project->id
                ]);
            }

            event(new BlogCreatedEvent($project));


            DB::commit();

            return $project;


        } catch (\Exception $e) {

            DB::rollBack();

            throw new \Exception($e->getMessage());
        }
    }
}
