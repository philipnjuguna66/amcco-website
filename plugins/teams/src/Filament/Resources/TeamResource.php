<?php

namespace Appsorigin\Teams\Filament\Resources;


use Appsorigin\Teams\Filament\Resources\TeamResource\Pages\CreateTeam;
use Appsorigin\Teams\Filament\Resources\TeamResource\Pages\EditTeam;
use Appsorigin\Teams\Filament\Resources\TeamResource\Pages\ListTeam;

use Appsorigin\Teams\Models\CompanyTeam;
use Appsorigin\Teams\Models\TeamCategory;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class TeamResource extends Resource
{
    protected static ?string $model = CompanyTeam::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-add';

    protected static ?string $navigationLabel = "Teams";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([

                    Section::make('Profile')->schema([
                        TextInput::make('name')
                            ->reactive()
                            ->afterStateUpdated(fn(\Closure $set, $state): string => $set('slug', str($state)->slug()))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('title')
                            ->reactive()
                            ->afterStateUpdated(fn(\Closure $set, $state): string => $set('slug', str($state)->slug()))
                            ->required()
                            ->maxLength(255),
                        RichEditor::make('body')
                            ->minLength(500),
                        Select::make('category')
                            ->required()
                            ->label('Role')
                            ->multiple()
                            ->options(TeamCategory::query()->pluck('name', 'id')->toArray())
                            ->preload()
                            ->searchable()
                            ->getSearchResultsUsing(fn(string $search) => TeamCategory::query()->where('name', 'like', "%$search%")->pluck('name', 'id')->toArray())
                            ->createOptionModalHeading("create a team category")
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required()
                                    ->unique('team_categories', 'name')
                            ])
                            ->createOptionUsing(fn(array $data) => TeamCategory::create(['name' => $data['name']]))
                    ]),
                ])->columnSpan([
                    12,
                    'lg' => 8,
                ]),

                Group::make([

                    Section::make('featured image')
                        ->schema([

                            DatePicker::make('created_at')
                                ->reactive()
                                ->visible(fn(Page $livewire): bool => $livewire instanceof EditTeam)
                                ->required(),
                            FileUpload::make('featured_image')
                                ->disableLabel(true)
                                ->required()
                                ->preserveFilenames(),
                        ]),
                ])
                    ->columnSpan([
                        12,
                        'lg' => 4,
                    ]),

            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('featured_image')->circular(),
                TextColumn::make('name'),
                TextColumn::make('title'),
                TextColumn::make('updated_at')
                    ->label('Last Modified at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                ReplicateAction::make()->excludeAttributes(['id'])
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTeam::route('/'),
            'create' => CreateTeam::route('/create'),
            'edit' => EditTeam::route('/{record}/edit'),
        ];
    }

}
