<?php

namespace App\Http\Livewire\Blog;

use App\Models\Tag;
use App\Utils\Enums\ProjectStatusEnum;
use Appsorigin\Blog\Models\Blog;
use Appsorigin\Plots\Models\Location;
use Appsorigin\Plots\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class TagPosts extends Component
{
    use WithPagination;

    public ?Tag $tag;

    public $take = 10;

    public $grid = 3;
    public function mount(?Tag $branch)
    {
        $this->tag = $branch->loadMissing('blogs');

    }

    public function render()
    {

        $blogs = Blog::query()
            ->with('link')
            ->where('is_published', true)
            ->inRandomOrder()
            ->when(isset($this->tag?->id), fn(Builder $query) => $query->whereHas('tags', fn($query) =>
            $query->whereIn('blog_id', $this->tags?->blogs()->pluck('blog_id')->toArray()))
            );

        return view('livewire.blog.blog-list')->with([
            'blogs' => $blogs->simplePaginate($this->take ?? 6),
        ]);
    }
}
