<?php

namespace Appsorigin\Testimonial;

use Appsorigin\Plots\Filament\Resources\LocationResource;
use Appsorigin\Plots\Filament\Resources\ProjectResource;
use Appsorigin\Testimonial\Filament\Resources\TestimonialResource;
use Filament\PluginServiceProvider;

use Spatie\LaravelPackageTools\Package;

class TestimonialServiceProvider extends PluginServiceProvider
{

    public function configurePackage(Package $package): void
    {
        $package->name('apps-testimonial');
    }



    protected array $resources = [

        TestimonialResource::class,
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
