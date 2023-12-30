<?php

namespace App\Models;

use App\Utils\Concerns\InteractsWithPermerlinks;
use Appsorigin\Blog\Models\Blog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    use InteractsWithPermerlinks;

    const CACHE_KEY = 'tag';


    public function blogs()
    {
        return $this->belongsToMany(Blog::class ,'blog_tags');
    }
}
