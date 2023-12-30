<?php

namespace App\Filament\Pages;

use App\Settings\SiteOptionSettings;
use Filament\Forms;
use Filament\Pages\SettingsPage;

class ManageSiteOptionsSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = SiteOptionSettings::class;
    protected static ?string $navigationLabel = "site settings";

    protected static ?string $navigationGroup = 'SETTINGS';


    protected function getFormSchema(): array
    {
        return  [

            Forms\Components\TextInput::make('name'),
            Forms\Components\TextInput::make('meta_title'),
            Forms\Components\TextInput::make('meta_description'),
            Forms\Components\FileUpload::make('logo')->preserveFilenames(),
            Forms\Components\FileUpload::make('favicon')->preserveFilenames(),
        ];
    }
}
