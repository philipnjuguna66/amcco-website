<?php

namespace App\Filament\Pages;

use App\Settings\HeaderSettings;
use Filament\Forms;
use Filament\Pages\SettingsPage;

class ManageHeaderSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = HeaderSettings::class;

    protected static ?string $navigationGroup = 'SETTINGS';


    protected function getFormSchema(): array
    {
        return  [
            Forms\Components\Repeater::make('phones')
                ->schema([
                    Forms\Components\TextInput::make('label')->required(),
                    Forms\Components\TextInput::make('link'),
                ])
                ->defaultItems(1)
                ->maxItems(3)
                ->collapsible(),

            Forms\Components\Repeater::make('cta')
                ->schema([
                    Forms\Components\TextInput::make('label')->required(),
                    Forms\Components\TextInput::make('url'),
                    Forms\Components\Checkbox::make('button'),
                ])
                ->maxItems(3)
                ->collapsible(),
        ];
    }
}
