<?php

namespace Appsorigin\Teams\Models;

use App\Models\Permalink;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CompanyTeam extends Model
{

    const CACHE_KEY = 'team';

    protected $casts = [
        'socials' => 'json'
    ];

    protected $appends = [
        'meta_title',
        'meta_description'
    ];

    public function link()
    {
        return $this->morphOne(Permalink::class, 'linkable');
    }

    public function metaTitle() : Attribute
    {
        return  new Attribute(
            get: fn()  => str($this->name)->toString()
        );

    }
    public function metaDescription() : Attribute
    {
        return  new Attribute(
            get: fn()  => str($this->body)->limit(168)->toString()
        );

    }

    public function teamCategories() : BelongsToMany
    {
        return $this->belongsToMany(
            related: TeamCategory::class,
            table: 'company_team_categories',
            foreignPivotKey: 'company_team_id',
            relatedPivotKey: 'team_category_id'
        );
    }
}
