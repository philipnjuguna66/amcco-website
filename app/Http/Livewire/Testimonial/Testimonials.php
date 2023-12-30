<?php

namespace App\Http\Livewire\Testimonial;

use Appsorigin\Plots\Models\Blog;
use Appsorigin\Testimonial\Models\Testimonial;
use Livewire\Component;
use Livewire\WithPagination;

class Testimonials extends Component
{
    use  WithPagination;
    const CACHE_KEY = 'tetimonials';


    public $take = 0;


    public function mount(?int $take): void
    {

        $this->take = $take;
    }

    public function render()
    {


        $blogs = Testimonial::query()
            ->latest('created_at');

        if ($this->take > 0) {

            $blogs = $blogs
                ->limit($this->take);
        }

        return view('livewire.testimonials.testimonials')->with([
            'testimonials' => $blogs->simplePaginate($this->take ?? 6),
        ]);
    }
}
