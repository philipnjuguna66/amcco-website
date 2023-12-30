<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SiteOptionSettings extends Settings
{
    public string $name;

    public string $meta_title;

    public string $meta_description;

    public string $logo;

    public string $favicon;

    public  array $socials = [];

    public static function group(): string
    {
        return 'options';
    }
}
