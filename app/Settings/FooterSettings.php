<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class FooterSettings extends Settings
{
    public $sections;

    public static function group(): string
    {
        return 'footer';
    }
}
