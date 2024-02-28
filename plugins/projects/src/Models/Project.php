<?php

namespace Appsorigin\Plots\Models;

use App\Models\Permalink;
use App\Utils\Concerns\InteractsWithPermerlinks;
use App\Utils\Enums\ProjectStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Project extends Model  implements Sitemapable
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


    public function toSitemapTag(): Url | string | array
    {
        // Return with fine-grained control:
        return Url::create(route('permalink.show', $this->link?->slug))
            ->setLastModificationDate(Carbon::create($this->updated_at))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(0.1);
    }


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
