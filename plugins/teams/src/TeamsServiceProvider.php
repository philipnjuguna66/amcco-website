<?php

namespace Appsorigin\Teams;

use Appsorigin\Teams\Filament\Resources\TeamResource;
use Filament\PluginServiceProvider;

use Spatie\LaravelPackageTools\Package;

class TeamsServiceProvider extends PluginServiceProvider
{

    public function configurePackage(Package $package): void
    {
        $package->name('apps-teams');
    }



    protected array $resources = [

        TeamResource::class,
    ];

    protected array $pages  = [];


    protected array $widgets = [];


    public function packageBooted(): void
    {

        $this->loadMigrationsFrom([
            __DIR__ . '/../database/migrations',
        ]);

        parent::packageBooted();
    }

}
