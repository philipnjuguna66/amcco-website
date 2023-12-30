<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('options.name', ' Amcco Properties Limited');
        $this->migrator->add('options.meta_title', 'Prime and affordable Plots For Sale - Amcco Properties Limited- We Sell You Value');
        $this->migrator->add('options.meta_description', "Genuine Value Added Prime and affordable Plots and Land For Sale in Kenya - Kikuyu, Gikambura, Kamangu, Nachu, Thigio and Nairobi With Ready Title Deeds");
        $this->migrator->add('options.logo', "");
        $this->migrator->add('options.favicon', "");
        $this->migrator->add('options.extras', "");
        $this->migrator->add('options.socials', []);
    }
};
