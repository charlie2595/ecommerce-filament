<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Product Information')->schema([
                        TextInput::make('sku')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('name')
                            ->label('Product Name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Set $set) {
                                if ($operation !== 'create') {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            }),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated()
                            ->unique(Product::class, 'slug', ignoreRecord:true),

                        MarkdownEditor::make('description')
                            ->columnSpanFull()
                            ->fileAttachmentsDirectory('product')
                    ])->columns(2),
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('Price')->schema([
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('IDR'),
                    ]),

                    Section::make('Associations')->schema([
                        Select::make('unit_id')
                            ->relationship('unit', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('brand_id')
                            ->relationship('brand', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),

                    Section::make('Status')->schema([
                        Toggle::make('is_ppn')
                            ->required()
                            ->default(true),

                        Toggle::make('is_popular')
                            ->required()
                            ->default(true),
                    ]),

                ])->columnSpan(1),

                Section::make('Images')
                ->schema([
                    FileUpload::make('thumbnail')
                        ->required()
                        ->image(),

                    Repeater::make('images')
                        ->relationship('images') // relasi HasMany
                        ->schema([
                            FileUpload::make('image') // kolom di tabel relasi 'image'
                                ->image()
                                ->imagePreviewHeight('150')
                                ->required()
                        ])
                        ->reorderable()
                        ->collapsible()
                        ->defaultItems(1)
                ])->columns(2),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->searchable(),
                TextColumn::make('brand.name')
                    ->searchable(),
                TextColumn::make('unit.name')
                    ->searchable(),
                ImageColumn::make('thumbnail')
                    ->circular(),
                TextColumn::make('price')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('quantity')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault:true),
                IconColumn::make('is_ppn')
                    ->boolean(),
                IconColumn::make('is_popular')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault:true),
            ])
            ->filters([
                SelectFilter::make('unit_id')
                    ->label('unit')
                    ->relationship('unit', 'name'),

                SelectFilter::make('category_id')
                    ->label('category')
                    ->relationship('category', 'name'),

                SelectFilter::make('brand_id')
                    ->label('brand')
                    ->relationship('brand', 'name'),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
