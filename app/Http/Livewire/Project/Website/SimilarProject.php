<?php

namespace App\Http\Livewire\Project\Website;

use App\Utils\Enums\ProjectStatusEnum;
use Appsorigin\Plots\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class SimilarProject extends Component
{
    use WithPagination;

    public ?Project $project;

    public $take = 3;

    public $grid = 3;

    public function mount(?Project $project)
    {
        $this->project = $project;

    }

    public function render()
    {

        $projects = Project::query()
            ->whereNot('id', $this->project?->id)
            ->where('status', ProjectStatusEnum::FOR_SALE)
            ->inRandomOrder()
            ->with('link')
            ->take(3)
            ->when(isset($this->project?->id), fn(Builder $query) => $query->whereHas('branches', fn($query) =>
            $query->whereIn('location_id', $this->project?->branches()->pluck('location_id')->toArray()))
            )
            ->paginate(3);

        return view('livewire.project.website.list-project')->with(['projects' => $projects]);
    }
}
