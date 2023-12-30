<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Concerns\BlogsFormSectionConcern;
use App\Filament\Resources\Concerns\BookSiteVisitSectionConcern;
use App\Filament\Resources\Concerns\CardFormSectionConcern;
use App\Filament\Resources\Concerns\FAQFormSectionConcern;
use App\Filament\Resources\Concerns\FullImageWidthFormSectionConcern;
use App\Filament\Resources\Concerns\HeroImageSectionConcern;
use App\Filament\Resources\Concerns\ProjectFormSectionConcern;
use App\Filament\Resources\Concerns\SliderSectionConcern;
use App\Filament\Resources\Concerns\StatsSectionConcern;
use App\Filament\Resources\Concerns\TestimonialSectionConcern;
use App\Filament\Resources\Concerns\VideoFormSectionConcern;
use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    use ProjectFormSectionConcern, BookSiteVisitSectionConcern , HeroImageSectionConcern, BlogsFormSectionConcern, FullImageWidthFormSectionConcern;
    use VideoFormSectionConcern , CardFormSectionConcern, FAQFormSectionConcern, StatsSectionConcern,TestimonialSectionConcern , SliderSectionConcern;

    public static function build(): static
    {

        return new self();

    }

    protected static ?string $navigationIcon = 'heroicon-o-annotation';

    public static function form(Form $form): Form
    {
        //dd(Page::query()->where('is_front_page', 1)->count());
        return $form
            ->schema([
                Forms\Components\Grid::make()->schema([
                    TextInput::make('title')->reactive()
                        ->afterStateUpdated(fn (\Closure $set, $state): string => $set('slug', str($state)->slug()))
                        ->required()->unique(
                            ignoreRecord: true
                        ),
                    TextInput::make('slug')
                        ->required()
                        ->unique('permalinks', ignorable: fn (?Page $record) => ($record?->link)),
                    Checkbox::make('is_front_page')
                        ->default(false)
                        ->label(fn (): string => Page::query()->where('is_front_page', true)->count() ? 'Front Page defined' : 'Is front Page')
                        ->disabled(fn (): bool => Page::query()->where('is_front_page', true)->count()),
                    TextInput::make('meta_title')->required()->unique(ignoreRecord: true),
                    TextInput::make('meta_description')->unique(ignoreRecord: true),

                ]),

                Builder::make('sections')->label('Page Sections')
                    ->blocks([
                        static::build()->videoSection(),
                        static::build()->bookSiteVisitSection(),
                        static::build()->headerSection(),
                        static::build()->statsSection(),
                        static::build()->testimonialsSection(),
                        static::build()->videoSection(),
                        static::build()->faqSection(),
                        static::build()->accordionSection(),
                        static::build()->timeline(),
                        static::build()->teamSection(),
                        static::build()->heroLeftImage(),
                        static::build()->cardSection(),
                        static::build()->htmlSection(),
                        static::build()->fullImageWidthSection(),
                        static::build()->sliderSection(),
                        static::build()->projectSection(),
                        static::build()->blogSection(),
                        static::build()->gallerySection(),
                        static::build()->pastProjectSection(),
                        static::build()->heroWithService(),
                        static::build()->heroPageBuilder(),

                    ])
                    ->columns(3)
                    ->collapsed()
                ->collapsible(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->size('sm'),
                Tables\Columns\IconColumn::make('is_front_page')->boolean()->size('sm'),
                Tables\Columns\TextColumn::make('meta_title')->size('sm'),
                Tables\Columns\IconColumn::make('is_published')
                    ->size('sm')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')->size('sm')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
