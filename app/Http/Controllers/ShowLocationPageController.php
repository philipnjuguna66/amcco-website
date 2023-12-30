<?php

namespace App\Http\Controllers;

use Appsorigin\Plots\Models\Location;

class ShowLocationPageController extends Controller
{
    public function __invoke(Location $branch)
    {

        return view('pages.locations.archives', [
                'branch' => $branch ,
            ]);


    }
}
