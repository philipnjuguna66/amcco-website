<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\Permalink;
use App\Models\Whatsapp;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use RyanChandler\FilamentNavigation\Facades\FilamentNavigation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        Model::preventLazyLoading(!app()->isProduction());

        $this->customDirectives();

        $this->readDuration();

        $this->morphsSchemas();

        FilamentNavigation::addItemType('Internal Page', [
            Select::make('url')
                ->searchable()
                ->options(function () {
                    return Permalink::query()->where('type', 'page')->pluck('title', 'slug');
                }),
        ]);
    }

    private function customDirectives(): void
    {

        View::composer('layouts.partials.footer', fn(\Illuminate\View\View $view) => $view->with([
            'whatsApp' => Whatsapp::query()->inRandomOrder()->pluck('phone_number')->first()
        ]));


        Blade::directive('meta', function ($expression): string {
            [$property, $content] = explode(',', $expression, 2);
            $metas = '';

            $newContent = str($content)
                ->stripTags()
                ->replace('<a>','')
                ->replace('</a>','')
                ->trim()
                ->toString();

            if ($property == 'description') {

                $metas .= "<?php echo '<meta  class=\"hidden\"  property=\"description\" content=\"' .$newContent . '\">' . \"\n\"; ?>";

            }

            $metas .= "<?php echo '<meta class=\"hidden\"  property=\"og:' . $property . '\" content=\"' . $newContent . '\">' . \"\n\"; ?>";
            $metas .= "<?php echo '<meta class=\"hidden\"  property=\"twitter:' . $property . '\" content=\"' . $newContent . '\">' . \"\n\"; ?>";
            $metas .= "<?php echo '<meta  class=\"hidden\" property=\"article:' . $property . '\" content=\"' . $newContent . '\">' . \"\n\"; ?>";

            return $metas;
        });
    }

    private function readDuration(): void
    {
        Str::macro('readDuration', function (...$text): int {
            $totalWords = str_word_count(implode(' ', $text));
            $minutesToRead = round($totalWords / 200);

            return (int)max(1, $minutesToRead);
        });
    }

    private function morphsSchemas()
    {
        return Relation::morphMap([
            'page' => Page::class,
        ]);
    }
}
