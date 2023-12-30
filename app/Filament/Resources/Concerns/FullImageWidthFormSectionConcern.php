<?php

namespace App\Filament\Resources\Concerns;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

trait FullImageWidthFormSectionConcern
{
    protected function fullImageWidthSection(): Block
    {
        return Block::make('full_image_width')->schema([

            FileUpload::make('image')->nullable(),
            TextInput::make('url'),

        ]);
    }

    protected function gallerySection(): Block
    {
        return Block::make('gallery_section')->schema([
            TextInput::make('heading'),
            Select::make('type')
                ->options([
                    'slider' => 'Slider',
                    'grid' => 'Grid',
                ])
                ->required()
                ->reactive()
                ->searchable()
                ->preload(),
            Grid::make(1)
                ->schema([

                    RichEditor::make('content'),
                    Grid::make(2)->schema([
                        TextInput::make('cta_url')->label('cta url'),
                        TextInput::make('cta_name')->label('cta label'),
                    ]),
                ])
                ->hidden(fn (\Closure $get): bool => $get('type') == 'grid'),

            Repeater::make('images')->schema([
                FileUpload::make('image')->preserveFilenames()->required(),
                TextInput::make('image_name')->label('Image Name'),
                TextInput::make('url'),
            ]),

        ]);
    }
}
