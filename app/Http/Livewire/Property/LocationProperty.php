<?php

namespace App\Http\Livewire\Property;

use App\Models\Location;
use Appsorigin\Plots\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class LocationProperty extends Component
{
    use WithPagination;

    public Location $location;


    public function mount($location){

        $this->location = $location;

    }
    public function render()
    {
        return view('livewire.property.location-property')
            ->with([
                'projects' => Project::query()->where('location_id', $this->location->id)->paginate(10)
            ])
            ->layout('layouts.guest');
    }
}
