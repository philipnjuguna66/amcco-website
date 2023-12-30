<?php

namespace Appsorigin\Leads\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    const CACHE_KEY = "leads";
    use HasFactory;
}
