<?php

namespace App\Listeners;

use App\Events\PageCreatedEvent;
use App\Models\Page;
use Illuminate\Support\Facades\Cache;

class PageCreatedListener
{
    public function handle(PageCreatedEvent $event): void
    {

        $key = Page::CACHE_KEY.".{$event->page->id}";

        Cache::forget($key);

        Cache::forever($key, $event->page->loadMissing('sections', 'link'));


    }
}
