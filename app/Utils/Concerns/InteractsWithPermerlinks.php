<?php

namespace App\Utils\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait InteractsWithPermerlinks
{

    public function getTitle(): string
    {
        return str($this->title)->title();
    }

    public function getContent(): string
    {
        return $this->body;
    }

    public function getMetaTitle(): string
    {
        return str($this->meta_title)->headline()->value();
    }

    public function metaDescription(): Attribute
    {
        return  new Attribute(
            get: fn($value) : string => str($this->meta_description)
                ->stripTags()
                ->replace('<a>','')
                ->replace('</a>','')
                ->trim()
                ->toString()
        );
    }
}
