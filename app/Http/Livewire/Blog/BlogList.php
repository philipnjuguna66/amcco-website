<?php

namespace App\Http\Livewire\Blog;

use App\Models\Tag;
use Appsorigin\Blog\Models\Blog;
use Livewire\Component;
use Livewire\WithPagination;

class BlogList extends Component
{
    use  WithPagination;

    const CACHE_KEY = 'post';

    public $take = 0;

    public ?Tag $tag;

    public function mount(?int $take): void
    {

        $this->take = $take;
    }

    public function render()
    {


        $blogs = Blog::query()
            ->latest('created_at')
            ->where('is_published', true);

        if ($this->take > 0) {

            $blogs = $blogs
                ->limit($this->take);
        }

        return view('livewire.blog.blog-list')->with([
            'blogs' => $blogs->simplePaginate($this->take ?? 6),
        ]);
    }
}
