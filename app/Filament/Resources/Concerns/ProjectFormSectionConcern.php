<?php

namespace App\Filament\Resources\Concerns;

use App\Models\Permalink;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

trait ProjectFormSectionConcern
{
    protected function projectSection(): Block
    {
        return Block::make('project_section')->schema([
            TextInput::make('heading')->required(),
            TextInput::make('subheading')->required(),

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
            ->searchable()
            ->preload(),
        ]);
    }

    protected function pastProjectSection(): Block
    {
        return Block::make('past_project_section')->schema([
            TextInput::make('heading')->required(),
            TextInput::make('subheading'),
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
            ->searchable()
            ->preload(),
        ]);
    }
}
