<?php

namespace App\Http\Controllers;

use App\Models\Permalink;
use App\Models\Whatsapp;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ShowPropertyController extends Controller
{
    public function __invoke(Permalink $permalink)
    {
        $previewKey  =  $permalink->id;


        if (! Cache::has($previewKey))
        {
            Cache::increment(
                key: $previewKey,
            );
        }

        $views = Cache::get($previewKey, 1);





        return view('pages.property.single', [
            'page' => $permalink->linkable,
            'views'  => $views,
        ]);
    }
}
