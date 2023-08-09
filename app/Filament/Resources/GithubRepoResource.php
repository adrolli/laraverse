<?php

namespace App\Filament\Resources;

use App\Models\GithubRepo;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\GithubRepoResource\Pages;

class GithubRepoResource extends Resource
{
    protected static ?string $model = GithubRepo::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

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

                    KeyValue::make('data')
                        ->required()
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('github_organization_id')
                        ->rules(['exists:github_organizations,id'])
                        ->required()
                        ->relationship('githubOrganization', 'title')
                        ->searchable()
                        ->placeholder('Github Organization')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('github_owner_id')
                        ->rules(['exists:github_owners,id'])
                        ->required()
                        ->relationship('githubOwner', 'title')
                        ->searchable()
                        ->placeholder('Github Owner')
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
                Tables\Columns\TextColumn::make('githubOrganization.title')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('githubOwner.title')
                    ->toggleable()
                    ->limit(50),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('github_organization_id')
                    ->relationship('githubOrganization', 'title')
                    ->indicator('GithubOrganization')
                    ->multiple()
                    ->label('GithubOrganization'),

                SelectFilter::make('github_owner_id')
                    ->relationship('githubOwner', 'title')
                    ->indicator('GithubOwner')
                    ->multiple()
                    ->label('GithubOwner'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            GithubRepoResource\RelationManagers\ItemsRelationManager::class,
            GithubRepoResource\RelationManagers\GithubTagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGithubRepos::route('/'),
            'create' => Pages\CreateGithubRepo::route('/create'),
            'view' => Pages\ViewGithubRepo::route('/{record}'),
            'edit' => Pages\EditGithubRepo::route('/{record}/edit'),
        ];
    }
}
