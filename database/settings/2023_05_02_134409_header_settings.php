<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('header.phones', []);

        $this->migrator->add('header.cta', []);
        $this->migrator->add('header.favicon', "");
    }
};
