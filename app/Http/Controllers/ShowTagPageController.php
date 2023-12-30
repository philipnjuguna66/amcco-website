<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class ShowTagPageController extends Controller
{
    public function __invoke(Tag $tag)
    {

        return view('pages.tags.archives', [
                'tag' => $tag ,
            ]);


    }
}
