<?php

namespace App\Filament\Resources\StackResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\RelationManager;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                TextInput::make('title')
                    ->rules(['max:255', 'string'])
                    ->placeholder('Title')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('slug')
                    ->rules(['max:255', 'string'])
                    ->placeholder('Slug')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                RichEditor::make('description')
                    ->rules(['max:255', 'string'])
                    ->placeholder('Description')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('latest_version')
                    ->rules(['max:255', 'string'])
                    ->placeholder('Latest Version')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                KeyValue::make('versions')->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),

                Select::make('vendor_id')
                    ->rules(['exists:vendors,id'])
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
                    ->placeholder('Website')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('ranking')
                    ->rules(['numeric'])
                    ->numeric()
                    ->placeholder('Ranking')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('popularity')
                    ->rules(['numeric'])
                    ->numeric()
                    ->placeholder('Popularity')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                KeyValue::make('popularity_data')->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),

                TextInput::make('rating')
                    ->rules(['numeric'])
                    ->numeric()
                    ->placeholder('Rating')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                KeyValue::make('rating_data')->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),

                TextInput::make('health')
                    ->rules(['numeric'])
                    ->numeric()
                    ->placeholder('Health')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                KeyValue::make('health_data')->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),

                TextInput::make('github_url')
                    ->rules(['max:255', 'string'])
                    ->placeholder('Github Url')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('github_stars')
                    ->rules(['numeric'])
                    ->numeric()
                    ->placeholder('Github Stars')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('packagist_url')
                    ->rules(['max:255', 'string'])
                    ->placeholder('Packagist Url')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('packagist_name')
                    ->rules(['max:255', 'string'])
                    ->placeholder('Packagist Name')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('packagist_description')
                    ->rules(['max:255', 'string'])
                    ->placeholder('Packagist Description')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('packagist_downloads')
                    ->rules(['numeric'])
                    ->numeric()
                    ->placeholder('Packagist Downloads')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('packagist_favers')
                    ->rules(['numeric'])
                    ->numeric()
                    ->placeholder('Packagist Favers')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('npm_url')
                    ->rules(['max:255', 'string'])
                    ->placeholder('Npm Url')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('github_maintainers')
                    ->rules(['numeric'])
                    ->numeric()
                    ->placeholder('Github Maintainers')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                KeyValue::make('php_compatibility')->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),

                KeyValue::make('laravel_compatibilty')->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),

                Select::make('repository_id')
                    ->rules(['exists:repositories,id'])
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
                    ->relationship('packagistPackage', 'title')
                    ->searchable()
                    ->placeholder('Packagist Package')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->limit(50),
                Tables\Columns\TextColumn::make('slug')->limit(50),
                Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\TextColumn::make('latest_version')->limit(50),
                Tables\Columns\TextColumn::make('vendor.title')->limit(50),
                Tables\Columns\TextColumn::make('itemType.title')->limit(50),
                Tables\Columns\TextColumn::make('website')->limit(50),
                Tables\Columns\TextColumn::make('ranking'),
                Tables\Columns\TextColumn::make('popularity'),
                Tables\Columns\TextColumn::make('rating'),
                Tables\Columns\TextColumn::make('health'),
                Tables\Columns\TextColumn::make('github_url')->limit(50),
                Tables\Columns\TextColumn::make('github_stars'),
                Tables\Columns\TextColumn::make('packagist_url')->limit(50),
                Tables\Columns\TextColumn::make('packagist_name')->limit(50),
                Tables\Columns\TextColumn::make('packagist_description')->limit(
                    50
                ),
                Tables\Columns\TextColumn::make('packagist_downloads'),
                Tables\Columns\TextColumn::make('packagist_favers'),
                Tables\Columns\TextColumn::make('npm_url')->limit(50),
                Tables\Columns\TextColumn::make('github_maintainers'),
                Tables\Columns\TextColumn::make('repository.title')->limit(50),
                Tables\Columns\TextColumn::make('npmPackage.title')->limit(50),
                Tables\Columns\TextColumn::make(
                    'packagistPackage.title'
                )->limit(50),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '>=',
                                    $date
                                )
                            )
                            ->when(
                                $data['created_until'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '<=',
                                    $date
                                )
                            );
                    }),

                MultiSelectFilter::make('vendor_id')->relationship(
                    'vendor',
                    'title'
                ),

                MultiSelectFilter::make('itemType_id')->relationship(
                    'itemType',
                    'title'
                ),

                MultiSelectFilter::make('repository_id')->relationship(
                    'repository',
                    'title'
                ),

                MultiSelectFilter::make('npm_package_id')->relationship(
                    'npmPackage',
                    'title'
                ),

                MultiSelectFilter::make('packagist_package_id')->relationship(
                    'packagistPackage',
                    'title'
                ),
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }
}
