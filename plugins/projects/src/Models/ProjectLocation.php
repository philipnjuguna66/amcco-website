<?php

namespace Appsorigin\Plots\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectLocation extends Model
{
    use HasFactory;
    const CACHE_KEY = "projectLocation";

    protected $table = 'project_branches';

}
