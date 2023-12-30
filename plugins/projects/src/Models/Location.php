<?php

namespace Appsorigin\Plots\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Location extends Model
{
    use HasFactory;

    const CACHE_KEY = "location";
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class,'project_branches','location_id','project_id');
    }
}
