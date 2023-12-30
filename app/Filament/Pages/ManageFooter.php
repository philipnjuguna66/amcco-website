<?php

namespace App\Filament\Pages;

use App\Settings\FooterSettings;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;

class ManageFooter extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = FooterSettings::class;

    protected static ?string $navigationGroup = 'SETTINGS';

    protected function fillForm(): void
    {
        $this->callHook('beforeFill');

        $settings = app(static::getSettings());

        $data = $this->mutateFormDataBeforeFill($settings->toArray());
        if ($data['sections'] == 'links') {
            $data['sections'] = [];
        }
      //  dd($data);

       $this->form->fill($data);

        $this->callHook('afterFill');
    }

    protected function getFormSchema(): array
    {
        return [

            Builder::make('sections')
            ->blocks([
                Builder\Block::make('list')
                ->schema([
                    TextInput::make('heading'),
                    Textarea::make('content')->maxLength(500),
                    Repeater::make('links')->schema([
                        Grid::make()->schema([
                            TextInput::make('label'),
                            TextInput::make('link'),
                        ]),
                    ])
                        ->collapsible()
                        ->createItemButtonLabel('new link')->defaultItems(2),

                ]),
                Builder\Block::make('text')
                ->schema([
                    TextInput::make('heading'),
                    RichEditor::make('content')->required()->maxLength(500),
                    FileUpload::make('logo')->preserveFilenames(),

                ]),
            ])
                ->collapsible()->maxItems(4)
                ->columnSpanFull(),

        ];
    }
}
