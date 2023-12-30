<?php

namespace Appsorigin\Blog\Models;

use App\Events\BlogCreatedEvent;
use App\Models\Permalink;
use App\Models\Tag;
use App\Utils\Concerns\InteractsWithPermerlinks;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
class Blog extends Model implements Sitemapable
{
    use HasFactory;
    use InteractsWithPermerlinks;

    const CACHE_KEY = 'post';

    protected $casts = [
        'is_published' => 'boolean',
    ];

    protected $with = [
        'link',
    ];

    public function toSitemapTag(): Url | string | array
    {
        // Return with fine-grained control:
        return Url::create(route('permalink.show', $this->link?->slug))
            ->setLastModificationDate(Carbon::create($this->updated_at))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(0.1);
    }

    protected $dispatchesEvents = [
        BlogCreatedEvent::class,
    ];
    public function link()
    {
        return $this->morphOne(Permalink::class, 'linkable');
    }
    public function tags() : BelongsToMany
    {
        return $this->belongsToMany(Tag::class,'blog_tags');
    }
}
