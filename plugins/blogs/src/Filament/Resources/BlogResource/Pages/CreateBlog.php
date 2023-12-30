<?php

namespace Appsorigin\Blog\Filament\Resources\BlogResource\Pages;

use App\Events\BlogCreatedEvent;
use Appsorigin\Blog\Filament\Resources\BlogResource;
use Appsorigin\Blog\Models\Blog;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateBlog extends CreateRecord
{
    protected static string $resource = BlogResource::class;

    protected function handleRecordCreation(array $data): Model
    {

        return DB::transaction(function () use ($data) {
            $blog = Blog::create([
                'title' => $data['title'],
                'body' => $data['body'],
                'is_published' => $data['is_published'],
                'canonical' => $data['canonical'],
                'meta_title' => $data['meta_title'],
                'meta_description' => $data['meta_description'],
                'featured_image' => $data['featured_image'],
            ]);

            $blog->link()->create([
                'type' => 'post',
                'slug' => $data['slug'],
            ]);

            event(new BlogCreatedEvent($blog));

            return $blog;
        });

    }
}
