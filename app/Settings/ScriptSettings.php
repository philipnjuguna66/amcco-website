<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ScriptSettings extends Settings
{
    public string $header;

    public string $body;

    public string $footer;

    public static function group(): string
    {
        return 'scripts';
    }
}
