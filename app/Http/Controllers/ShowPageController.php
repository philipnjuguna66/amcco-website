<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Permalink;
use App\Models\Whatsapp;
use Appsorigin\Plots\Models\Blog;
use Appsorigin\Plots\Models\Project;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ShowPageController extends Controller
{
    public function __invoke(Permalink $permalink)
    {
        try {
            $key = $permalink->linkable::CACHE_KEY . ".{$permalink->linkable_id}";


            if (!Cache::has($key)) {
                return redirect('/');
            }


            $page = Cache::get($key);

            $whatsApp = Whatsapp::query()->inRandomOrder()->first();

            if ($page instanceof Project) {

                $locationIds =  $page->branches()?->pluck('location_id')->toArray();

                $ids = [];

                foreach ($locationIds as $locationId) {

                    $ids[] = "$locationId";
                }

                $whatsApp = Whatsapp::query()
                    ->whereJsonContains('location_tags', $ids)
                    ->first();

            }


            return view($permalink->type->template(), [
                'page' => $page,
                'post' => $page,
                'whatsApp' => $whatsApp,
            ]);

        }
        catch (\Exception $e)
        {
            return redirect('/');
        }
    }
}
