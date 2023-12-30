<?php

namespace Appsorigin\Blog;

use Appsorigin\Blog\Filament\Resources\BlogResource;
use Appsorigin\Plots\Filament\Resources\LocationResource;
use Appsorigin\Plots\Filament\Resources\ProjectResource;
use Filament\PluginServiceProvider;

use Spatie\LaravelPackageTools\Package;

class BlogServiceProvider extends PluginServiceProvider
{

    public function configurePackage(Package $package): void
    {
        $package->name('apps-blogs');
    }



    protected array $resources = [

        BlogResource::class,
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
