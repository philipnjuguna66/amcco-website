<?php

namespace App\Http\Livewire\Teams;

use Appsorigin\Plots\Models\Blog;
use Appsorigin\Teams\Models\CompanyTeam;
use Appsorigin\Teams\Models\TeamCategory;
use Livewire\Component;
use Livewire\WithPagination;

class All extends Component
{
    use  WithPagination;

    const CACHE_KEY = 'post';

    public $take = 0;


    public $currentTeam = 1;

    public string $team = "";
    protected $queryString = [
        'team'
    ];

    public function mount(?int $take): void
    {

        $this->take = $take;


        $this->team =  str(TeamCategory::query()->first()?->name)->slug()->toString();
        $this->currentTeam = TeamCategory::query()->first()?->id;
    }

    public function updatedCurrentTeam( $value)
    {
        $this->team = str(TeamCategory::query()->where('id', $value)->first()?->name)->slug()->toString();

    }

    public function render()
    {

        $tabs = TeamCategory::query()->get();



        $teams = CompanyTeam::query()
            ->with('link')
            ->whereHas('teamCategories', function ($query){
                $query->where('company_team_categories.team_category_id', '=', $this->currentTeam);
            })
            ->oldest('created_at');

        if ($this->take > 0) {

            $teams = $teams
                ->limit($this->take);
        }


        return view('livewire.teams.all')->with([
            'teams' => $teams->simplePaginate($this->take ?? 6),
            'tabs' => $tabs
        ]);
    }
}
