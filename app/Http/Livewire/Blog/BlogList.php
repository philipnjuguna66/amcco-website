<?php

namespace App\Http\Livewire\Blog;

use App\Models\Tag;
use App\Utils\Enums\BlogTypeEnum;
use Appsorigin\Blog\Models\Blog;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class BlogList extends Component
{
    use  WithPagination;

    const CACHE_KEY = 'post';

    public $take = 0;
    public $grid = 3;

    public $type = BlogTypeEnum::POST;

    public bool $random =  false;

    public ?Tag $tag;

    public function mount(?int $take): void
    {

        $this->take = $take;
    }

    public function render()
    {


        $blogs = Blog::query()
            ->where('type', BlogTypeEnum::POST)
            ->when($this->random , fn(Builder $query) => $query->inRandomOrder())
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
