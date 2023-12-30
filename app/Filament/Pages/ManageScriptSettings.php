<?php

namespace App\Filament\Pages;

use App\Settings\ScriptSettings;
use Filament\Forms\Components\Textarea;
use Filament\Pages\SettingsPage;

class ManageScriptSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = ScriptSettings::class;

    protected static ?string $navigationGroup = 'SETTINGS';

    protected function mutateFormDataBeforeSave(array $data): array
    {
       return collect($data)
           ->filter(fn($value) => !empty($value))
           ->toArray();
    }

    protected function getFormSchema(): array
    {
        return [
            Textarea::make('header')
                ->helperText('between < head> tag')
                ->columnSpanFull()
            ->inlineLabel(),
            Textarea::make('body')
                ->helperText('after the < body> tage')
                ->columnSpanFull()
            ->inlineLabel(),
            Textarea::make('footer')
                ->helperText('before closing < /body>')
                ->columnSpanFull()
            ->inlineLabel(),
        ];
    }
}
