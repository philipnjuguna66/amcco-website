<?php

namespace Appsorigin\Plots;

use Appsorigin\Plots\Filament\Resources\LocationResource;
use Appsorigin\Plots\Filament\Resources\ProjectResource;
use Filament\PluginServiceProvider;

use Spatie\LaravelPackageTools\Package;

class PlotsServiceProvider extends PluginServiceProvider
{

    public function configurePackage(Package $package): void
    {
        $package->name('apps-plots');
    }



    protected array $resources = [
        ProjectResource::class,
        LocationResource::class,
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
