<?php

namespace App\Filament\Resources;

use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\RepositoryResource\Pages;
use App\Models\Repository;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RepositoryResource extends Resource
{
    protected static ?string $model = Repository::class;

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

                    TextInput::make('license')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('License')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    RichEditor::make('readme')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Readme')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    KeyValue::make('data')
                        ->required()
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    KeyValue::make('composer')
                        ->required()
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    KeyValue::make('npm')
                        ->required()
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    KeyValue::make('code_analyzer')
                        ->required()
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('package_type')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Package Type')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('repository_type_id')
                        ->rules(['exists:repository_types,id'])
                        ->required()
                        ->relationship('repositoryType', 'title')
                        ->searchable()
                        ->placeholder('Repository Type')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('organization_id')
                        ->rules(['exists:organizations,id'])
                        ->required()
                        ->relationship('organization', 'title')
                        ->searchable()
                        ->placeholder('Organization')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('owner_id')
                        ->rules(['exists:owners,id'])
                        ->required()
                        ->relationship('owner', 'title')
                        ->searchable()
                        ->placeholder('Owner')
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
                TextColumn::make('title')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                TextColumn::make('slug')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                TextColumn::make('description')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                TextColumn::make('license')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                TextColumn::make('readme')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                TextColumn::make('package_type')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                TextColumn::make('repositoryType.title')
                    ->toggleable()
                    ->limit(50),
                TextColumn::make('organization.title')
                    ->toggleable()
                    ->limit(50),
                TextColumn::make('owner.title')
                    ->toggleable()
                    ->limit(50),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('repository_type_id')
                    ->relationship('repositoryType', 'title')
                    ->indicator('RepositoryType')
                    ->multiple()
                    ->label('RepositoryType'),

                SelectFilter::make('organization_id')
                    ->relationship('organization', 'title')
                    ->indicator('Organization')
                    ->multiple()
                    ->label('Organization'),

                SelectFilter::make('owner_id')
                    ->relationship('owner', 'title')
                    ->indicator('Owner')
                    ->multiple()
                    ->label('Owner'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RepositoryResource\RelationManagers\ItemsRelationManager::class,
            RepositoryResource\RelationManagers\RepositoryTagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRepositories::route('/'),
            'create' => Pages\CreateRepository::route('/create'),
            'view' => Pages\ViewRepository::route('/{record}'),
            'edit' => Pages\EditRepository::route('/{record}/edit'),
        ];
    }
}
