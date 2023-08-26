<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Item;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ItemResource\Pages;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    TextInput::make('title')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Title')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('slug')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Slug')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    RichEditor::make('description')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Description')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('latest_version')
                        ->rules(['max:255', 'string'])
                        ->nullable()
                        ->placeholder('Latest Version')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    KeyValue::make('versions')
                        ->nullable()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('vendor_id')
                        ->rules(['exists:vendors,id'])
                        ->required()
                        ->relationship('vendor', 'title')
                        ->searchable()
                        ->placeholder('Vendor')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('itemType_id')
                        ->rules(['exists:item_types,id'])
                        ->required()
                        ->relationship('itemType', 'title')
                        ->searchable()
                        ->placeholder('Item Type')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('website')
                        ->rules(['max:255', 'string'])
                        ->nullable()
                        ->placeholder('Website')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('ranking')
                        ->rules(['numeric'])
                        ->nullable()
                        ->numeric()
                        ->placeholder('Ranking')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('popularity')
                        ->rules(['numeric'])
                        ->nullable()
                        ->numeric()
                        ->placeholder('Popularity')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    KeyValue::make('popularity_data')
                        ->nullable()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('rating')
                        ->rules(['numeric'])
                        ->nullable()
                        ->numeric()
                        ->placeholder('Rating')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    KeyValue::make('rating_data')
                        ->nullable()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('health')
                        ->rules(['numeric'])
                        ->nullable()
                        ->numeric()
                        ->placeholder('Health')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    KeyValue::make('health_data')
                        ->nullable()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('github_url')
                        ->rules(['max:255', 'string'])
                        ->nullable()
                        ->placeholder('Github Url')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('github_stars')
                        ->rules(['numeric'])
                        ->nullable()
                        ->numeric()
                        ->placeholder('Github Stars')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('packagist_url')
                        ->rules(['max:255', 'string'])
                        ->nullable()
                        ->placeholder('Packagist Url')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('packagist_name')
                        ->rules(['max:255', 'string'])
                        ->nullable()
                        ->placeholder('Packagist Name')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('packagist_description')
                        ->rules(['max:255', 'string'])
                        ->nullable()
                        ->placeholder('Packagist Description')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('packagist_downloads')
                        ->rules(['numeric'])
                        ->nullable()
                        ->numeric()
                        ->placeholder('Packagist Downloads')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('packagist_favers')
                        ->rules(['numeric'])
                        ->nullable()
                        ->numeric()
                        ->placeholder('Packagist Favers')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('npm_url')
                        ->rules(['max:255', 'string'])
                        ->nullable()
                        ->placeholder('Npm Url')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('github_maintainers')
                        ->rules(['numeric'])
                        ->nullable()
                        ->numeric()
                        ->placeholder('Github Maintainers')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    KeyValue::make('php_compatibility')
                        ->nullable()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    KeyValue::make('laravel_compatibilty')
                        ->nullable()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('repository_id')
                        ->rules(['exists:repositories,id'])
                        ->nullable()
                        ->relationship('repository', 'title')
                        ->searchable()
                        ->placeholder('Repository')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('npm_package_id')
                        ->rules(['exists:npm_packages,id'])
                        ->nullable()
                        ->relationship('npmPackage', 'title')
                        ->searchable()
                        ->placeholder('Npm Package')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('packagist_package_id')
                        ->rules(['exists:packagist_packages,id'])
                        ->nullable()
                        ->relationship('packagistPackage', 'title')
                        ->searchable()
                        ->placeholder('Packagist Package')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('slug')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('description')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('latest_version')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('vendor.title')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('itemType.title')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('website')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('ranking')
                    ->toggleable()
                    ->searchable(true, null, true),
                Tables\Columns\TextColumn::make('popularity')
                    ->toggleable()
                    ->searchable(true, null, true),
                Tables\Columns\TextColumn::make('rating')
                    ->toggleable()
                    ->searchable(true, null, true),
                Tables\Columns\TextColumn::make('health')
                    ->toggleable()
                    ->searchable(true, null, true),
                Tables\Columns\TextColumn::make('github_url')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('github_stars')
                    ->toggleable()
                    ->searchable(true, null, true),
                Tables\Columns\TextColumn::make('packagist_url')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('packagist_name')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('packagist_description')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('packagist_downloads')
                    ->toggleable()
                    ->searchable(true, null, true),
                Tables\Columns\TextColumn::make('packagist_favers')
                    ->toggleable()
                    ->searchable(true, null, true),
                Tables\Columns\TextColumn::make('npm_url')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('github_maintainers')
                    ->toggleable()
                    ->searchable(true, null, true),
                Tables\Columns\TextColumn::make('repository.title')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('npmPackage.title')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('packagistPackage.title')
                    ->toggleable()
                    ->limit(50),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('vendor_id')
                    ->relationship('vendor', 'title')
                    ->indicator('Vendor')
                    ->multiple()
                    ->label('Vendor'),

                SelectFilter::make('itemType_id')
                    ->relationship('itemType', 'title')
                    ->indicator('ItemType')
                    ->multiple()
                    ->label('ItemType'),

                SelectFilter::make('repository_id')
                    ->relationship('repository', 'title')
                    ->indicator('Repository')
                    ->multiple()
                    ->label('Repository'),

                SelectFilter::make('npm_package_id')
                    ->relationship('npmPackage', 'title')
                    ->indicator('NpmPackage')
                    ->multiple()
                    ->label('NpmPackage'),

                SelectFilter::make('packagist_package_id')
                    ->relationship('packagistPackage', 'title')
                    ->indicator('PackagistPackage')
                    ->multiple()
                    ->label('PackagistPackage'),
            ])
            ->actions([ViewAction::make(), EditAction::make()])
            ->bulkActions([DeleteBulkAction::make()]);
    }

    public static function getRelations(): array
    {
        return [
            ItemResource\RelationManagers\PostsRelationManager::class,
            ItemResource\RelationManagers\ItemRelationsRelationManager::class,
            ItemResource\RelationManagers\ItemRelationsRelationManager::class,
            ItemResource\RelationManagers\PlatformsRelationManager::class,
            ItemResource\RelationManagers\TagsRelationManager::class,
            ItemResource\RelationManagers\CategoriesRelationManager::class,
            ItemResource\RelationManagers\StacksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'view' => Pages\ViewItem::route('/{record}'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
