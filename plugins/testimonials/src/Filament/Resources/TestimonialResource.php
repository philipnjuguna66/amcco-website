<?php

namespace Appsorigin\Testimonial\Filament\Resources;


use Appsorigin\Testimonial\Filament\Resources\TestimonialResource\Pages\CreateTestimonial;
use Appsorigin\Testimonial\Filament\Resources\TestimonialResource\Pages\EditTestimonial;
use Appsorigin\Testimonial\Filament\Resources\TestimonialResource\Pages\ListTestimonials;
use Appsorigin\Testimonial\Models\Testimonial;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-add';

    protected static ?string $label  = "Testimonials";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('heading')
                    ->required(),
                TextInput::make('client')->required(),

                Textarea::make('body')->maxLength(255)->required(),
                FileUpload::make('featured_image')->preserveFilenames()->nullable(),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('heading')->searchable(),
                Tables\Columns\TextColumn::make('client')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
               // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => ListTestimonials::route('/'),
            'create' => CreateTestimonial::route('/create'),
            'edit' => EditTestimonial::route('/{record}/edit'),
        ];
    }
}
