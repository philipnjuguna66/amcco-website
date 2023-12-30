<?php

namespace Appsorigin\Plots\Filament\Resources;


use App\Filament\Resources\Concerns\HeroImageSectionConcern;
use App\Utils\Enums\ProjectStatusEnum;
use Appsorigin\Plots\Filament\Resources\ProjectResource\Pages\CreateProject;
use Appsorigin\Plots\Filament\Resources\ProjectResource\Pages\EditProject;
use Appsorigin\Plots\Filament\Resources\ProjectResource\Pages\ListProjects;
use Appsorigin\Plots\Models\Location;
use Appsorigin\Plots\Models\Project;
use Appsorigin\Plots\Models\ProjectLocation;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\ReplicateAction;

class ProjectResource extends Resource
{
    use HeroImageSectionConcern;

    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-s-folder-open';


    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('PROJECT DETAILS')
                        ->schema([
                            Forms\Components\Checkbox::make('use_page_builder')
                                ->default(fn(?Project $record = null) => $record?->use_page_builder)->reactive(),


                            Grid::make()->schema([
                                TextInput::make('cta')
                                    ->label('cta')
                                    ->hidden(fn($get) :bool =>  $get('use_page_builder'))
                                    ->required()
                                    ->reactive()
                                    ->helperText("Send the word katani to 12334"),

                                TextInput::make('name')
                                    ->label('Title')
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(fn(\Closure $set, $state,Page $livewire , ?Project $record = null) =>
                                    $livewire instanceof  CreateProject ? $set('slug', str($state)->slug()) : $record->link?->slug)
                                    ->maxLength(255),
                                Select::make('status')
                                    ->options(function (): array {
                                        $cases = [];

                                        foreach (ProjectStatusEnum::cases() as $case) {

                                            $cases[$case->value] = str($case->value)->headline()->value();

                                        }

                                        return $cases;
                                    })
                                    ->enum(fn() => ProjectStatusEnum::class)
                                    ->required(),
                                TextInput::make('price')
                                    ->string()
                                    ->helperText("e.g: 1.3M")
                                    ->required(),
                                TextInput::make('video_path')
                                    ->hidden(fn($get) :bool =>  $get('use_page_builder'))
                                    ->maxLength(255),
                                RichEditor::make('amenities')

                                    ->hidden(fn($get) :bool =>  $get('use_page_builder'))
                                    ->columnSpanFull()
                                    ->required(),
                                TextInput::make('map')
                                    ->hidden(fn($get) :bool =>  $get('use_page_builder'))->label('embedded_google_map'),
                                Forms\Components\FileUpload::make('mutation')

                                    ->hidden(fn($get) :bool =>  $get('use_page_builder'))
                                    ->preserveFilenames()
                                    ->label('mutation'),
                                Select::make('location_id')
                                    ->label('Location Tags')
                                    ->options(Location::query()->pluck('name', 'id'))
                                    ->getSearchResultsUsing(fn(string $search) => Location::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id'))
                                    ->multiple()
                                    ->createOptionForm([
                                        Grid::make()
                                            ->schema([
                                                TextInput::make('name')
                                                    ->reactive()
                                                    ->afterStateUpdated(fn($set, $state) => $set('slug', str($state)->slug()))
                                                    // ->disabled(fn(Page $livewire) : bool => $livewire instanceof  Pages\EditProject)
                                                    ->required(),
                                                TextInput::make('slug')->required()->unique('locations', 'slug'),
                                            ]),
                                    ])
                                    ->createOptionModalHeading("Create a Location")
                                    ->createOptionUsing(function (array $data, \Closure $set) {
                                        if (Location::query()->where([
                                            'name' => $data['name'],
                                            'slug' => $data['slug'],
                                        ])->exists())
                                        {
                                            return Notification::make()
                                                ->title("Something went wrong")
                                                ->body("Location Tag already exists")
                                                ->send();
                                        }
                                        Location::create([
                                            'name' => $data['name'],
                                            'slug' => $data['slug'],
                                        ]);

                                    })
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('purpose')
                                            ->helperText("Building a Residential Home or For speculation purposes")
                                            ->required(),
                                        TextInput::make('location')
                                            ->helperText("Ruiru Kamakis, 6.5km from Eastern Bypass")
                                            ->required(),
                                    ]),


                                RichEditor::make('body')
                                    ->hidden(fn($get) :bool =>  $get('use_page_builder'))
                                    ->required()
                                    ->maxLength(65535)
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('gallery')

                                    ->hidden(fn($get) :bool =>  $get('use_page_builder'))
                                    ->multiple()
                                    ->maxSize('1024')
                                    ->maxWidth('800px')
                                    ->preserveFilenames()
                                    ->columnSpanFull(),
                            ]),
                            Forms\Components\Builder::make('sections')
                                ->schema([
                                    (new self())->heroPageBuilder()
                                ])
                                ->visible(fn($get) :bool =>  $get('use_page_builder')),
                        ]),
                ])->columnSpan([
                    12,
                    'lg' => 8,
                ]),
                Group::make()->label('SEO SETTINGS')->schema([
                    Section::make('SEO SETTINGS')->schema([
                        TextInput::make('meta_title'),
                        TextInput::make('slug')
                            ->disabled(fn($livewire , ?Project $record =null) => ($livewire instanceof EditProject) && $record->status != ProjectStatusEnum::DRAFT),
                        Textarea::make('meta_description'),
                        Forms\Components\DateTimePicker::make('created_at')
                            ->visible(fn($livewire) => $livewire instanceof EditProject)

                    ]),
                    Section::make('Featured Image')->schema([
                        Forms\Components\FileUpload::make('featured_image')
                            ->required()
                            ->preserveFilenames(),
                    ]),
                ])->columnSpan([
                    12,
                    'lg' => 4,
                ]),

            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),

                Tables\Columns\TextColumn::make('location')
                    ->default(fn(Project $record) => $record->branches()?->implode('name', ' , ')),

                Tables\Columns\TextColumn::make('status')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('price'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ReplicateAction::make()->excludeAttributes(['slug'])->afterReplicaSaved(function (Project $replica, Project $record) {

                    $replica->updateQuietly([
                        'status' => ProjectStatusEnum::DRAFT
                    ]);

                    $replica->link()->create([
                        'slug' => str($record->title)->append("-")->append($replica->id)->slug(),
                        'type' => 'project',
                    ]);

                })

            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }
}
