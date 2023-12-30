<?php

namespace Appsorigin\Plots\Models;

use App\Models\Permalink;
use App\Utils\Concerns\InteractsWithPermerlinks;
use App\Utils\Enums\ProjectStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;
    use InteractsWithPermerlinks;

    const CACHE_KEY = "project";
    public $casts = [
        'status' => ProjectStatusEnum::class,
        'gallery' => 'json',
        'amenities' => 'json',
        'extra' => 'json'
    ];

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Location::class,'project_branches','project_id','location_id');
    }

    public function link()
    {
        return $this->morphOne(Permalink::class, 'linkable');
    }


    public function title() : Attribute
    {
        return  new Attribute(
            get: fn() => $this->name
        );
    }
}
