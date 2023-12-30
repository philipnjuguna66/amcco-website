<?php

namespace App\Listeners;

use App\Events\BlogCreatedEvent;
use Appsorigin\Plots\Models\Blog;
use Illuminate\Support\Facades\Cache;

class PostCreatedListener
{
    public function handle(BlogCreatedEvent $event): void
    {

        $key = $event->model::CACHE_KEY.".{$event->model->id}";

        Cache::forget($key);

        Cache::forever($key, $event->model->loadMissing('link'));
    }
}
