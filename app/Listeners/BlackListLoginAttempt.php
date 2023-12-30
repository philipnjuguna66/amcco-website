<?php

namespace App\Listeners;

use App\Models\BlackList;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class BlackListLoginAttempt
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Lockout $event): void
    {
      // handle blocked ips

        $key = Str::transliterate(Str::lower($event->request->input(Fortify::username())).'|'.$event->request->ip());

        dd($key, Cache::get($key, 0));
        BlackList::updateOrCreate([
            'ip' => $event->request->getClientIp(),

        ], ['event' => $event::class]);

        Cache::remember('black-list-ips',
            now()->addRealMinutes(60),
            fn (): array => BlackList::query()->pluck('ip')->toArray()
        );
    }
}
