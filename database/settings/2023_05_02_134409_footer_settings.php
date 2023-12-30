<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('footer.header', 'locations');
        $this->migrator->add('footer.sections', 'links');
    }
};
