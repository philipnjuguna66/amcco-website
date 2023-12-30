<?php

namespace App\Http\Livewire\Project\Website;

use App\Utils\Enums\ProjectStatusEnum;
use Appsorigin\Plots\Models\Location;
use Appsorigin\Plots\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class LocationProjects extends Component
{
    use WithPagination;

    public ?Location $branch;

    public $take = 10;

    public $grid = 3;
    public function mount(?Location $branch)
    {
        $this->branch = $branch->loadMissing('projects');

    }

    public function render()
    {

        $projects = Project::query()
            ->with('link')
            ->where('status', ProjectStatusEnum::FOR_SALE)
            ->inRandomOrder()
            ->when(isset($this->branch?->id), fn(Builder $query) => $query->whereHas('branches', fn($query) =>
            $query->whereIn('project_id', $this->branch?->projects()->pluck('project_id')->toArray()))
            )
            ->paginate(10);

        return view('livewire.project.website.list-project')->with(['projects' => $projects]);
    }
}
