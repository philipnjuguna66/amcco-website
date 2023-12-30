<?php

namespace Appsorigin\Blog\Filament\Resources;


use Appsorigin\Blog\Filament\Resources\BlogResource\Pages\CreateBlog;
use Appsorigin\Blog\Filament\Resources\BlogResource\Pages\EditBlog;
use Appsorigin\Blog\Filament\Resources\BlogResource\Pages\ListBlogs;
use Appsorigin\Blog\Filament\Resources\BlogResource\RelationManagers\TagsRelationManager;
use Appsorigin\Blog\Models\Blog;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\ReplicateAction;
use JKHarley\FilamentTrumbowyg\Trumbowyg;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make([

                    Forms\Components\Section::make('Article')->schema([
                        Forms\Components\TextInput::make('title')
                            ->reactive()
                            ->afterStateUpdated(fn (\Closure $set, $state): string => $set('slug', str($state)->slug()))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('body')
                            ->required(),
                        Forms\Components\Toggle::make('is_published')
                            ->required(),
                    ]),
                ])->columnSpan([
                    12,
                    'lg' => 8,
                ]),

                Forms\Components\Group::make([
                    Forms\Components\Section::make('SEO Settings')
                      ->schema([
                          Forms\Components\TextInput::make('slug')
                              ->disabled(function (): bool {
                                  return false;
                              })
                              ->required(),
                          Forms\Components\TextInput::make('meta_title')
                              ->required()
                              ->maxLength(153),
                          Forms\Components\TextInput::make('canonical')->url()
                              ->label("canonical URL")
                              ->nullable()
                              ->maxLength(153),
                          Forms\Components\Textarea::make('meta_description')
                              ->required()
                              ->maxLength(200),

                      ]),
                    Forms\Components\Section::make('featured image')
                    ->schema([

                        Forms\Components\FileUpload::make('featured_image')
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

                Tables\Columns\ImageColumn::make('featured_image')->circular(),
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Modified at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ReplicateAction::make()->excludeAttributes(['slug'])
            ])
            ->bulkActions([
              //  Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
             TagsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBlogs::route('/'),
            'create' => CreateBlog::route('/create'),
            'edit' => EditBlog::route('/{record}/edit'),
        ];
    }
}
