<?php

namespace App\Http\Livewire\Project\Website;

use App\Utils\Enums\ProjectStatusEnum;
use Appsorigin\Plots\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class ListProject extends Component
{
    use WithPagination;

    public $take = 0;

    public $grid = 3;

    public function mount(?int $take)
    {
        $this->take = $take;

    }

    public function render()
    {

        $projects = Project::query()
            ->with('link')
            ->latest('created_at')
            ->where('status',ProjectStatusEnum::FOR_SALE);

        if ($this->take > 0) {

            $projects = $projects
                ->limit($this->take);
        }

        return view('livewire.project.website.list-project')->with([
            'projects' => $projects->paginate($this->take ?? 6)
        ]);
    }
}
