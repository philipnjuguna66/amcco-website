<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class HeaderSettings extends Settings
{
    public array $phones = [];

    public  array  $cta  = [];

    public string $favicon = "";

    public static function group(): string
    {
        return 'header';
    }
}
