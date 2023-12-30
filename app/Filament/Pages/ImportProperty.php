<?php

namespace App\Filament\Pages;

use App\Imports\PropertiesImport;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Maatwebsite\Excel\Facades\Excel;

class ImportProperty extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.import-property';


    public $property;


    protected function getFormSchema(): array
    {
        return [
            FileUpload::make('property')
            ->required()
        ];
    }

    public function save()
    {

        try {
            $data = $this->form->getState();



            Excel::import(new PropertiesImport(), $data['property']);

            return Notification::make()
                ->body("successfully imported")
                ->success()->send();
        }
        catch (\Exception $e)
        {
            return Notification::make()
                ->title("something went wrong")
                ->danger()
                ->body($e->getMessage())->send();
        }

    }
}
