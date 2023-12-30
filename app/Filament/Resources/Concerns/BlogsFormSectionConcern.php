<?php

namespace App\Filament\Resources\Concerns;

use App\Models\Permalink;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

trait BlogsFormSectionConcern
{
    protected function blogSection(): Block
    {
        return Block::make('blog_section')->schema([
            TextInput::make('heading')->required(),
            TextInput::make('subheading')->nullable(),
            Checkbox::make('bg_white')->label('White Background')->nullable(),
            TextInput::make('count')->numeric(),
            Select::make('project_link')
                ->options(function (): array {

                    $options = [];

                    foreach (Permalink::query()->whereType('page')->cursor() as $link) {

                        $options[$link->slug] = $link->linkable?->name;

                    }

                    return $options;
                })

        ]);
    }
    protected function teamSection(): Block
    {
        return Block::make('team_section')->schema([
            TextInput::make('heading')->required(),
            Checkbox::make('bg_white')->label('White Background')->nullable(),
            TextInput::make('count')->numeric(),

        ]);
    }
}
