<?php

namespace App\Filament\Resources;

use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\RepositorySourceResource\Pages;
use App\Models\RepositorySource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;

class RepositorySourceResource extends Resource
{
    public static function getNavigationGroup(): string
    {
        return 'Taxonomies';
    }

    public static function getNavigationSort(): int
    {
        return 8;
    }

    public static function getNavigationLabel(): string
    {
        return 'Repository sources';
    }

    protected static ?string $model = RepositorySource::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()->schema([
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
            ])
            ->filters([DateRangeFilter::make('created_at')])
            ->actions([ViewAction::make(), EditAction::make()])
            ->bulkActions([DeleteBulkAction::make()]);
    }

    public static function getRelations(): array
    {
        return [
            RepositorySourceResource\RelationManagers\RepositoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRepositorySources::route('/'),
            'create' => Pages\CreateRepositorySource::route('/create'),
            'view' => Pages\ViewRepositorySource::route('/{record}'),
            'edit' => Pages\EditRepositorySource::route('/{record}/edit'),
        ];
    }
}
