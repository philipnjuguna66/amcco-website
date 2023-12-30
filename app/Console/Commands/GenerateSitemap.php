<?php
namespace App\Console\Commands;

use Appsorigin\Blog\Models\Blog;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command
{

    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the sitemap.';


    public function handle()
    {
        // modify this to your own needs
        SitemapGenerator::create(config('app.url'))
            ->getSitemap()
            ->add(Blog::all())
            ->writeToFile(public_path('sitemap.xml'));
    }
}
