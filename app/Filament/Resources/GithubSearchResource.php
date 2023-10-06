<?php

namespace App\Filament\Resources;

use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\GithubSearchResource\Pages;
use App\Models\GithubSearch;
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

class GithubSearchResource extends Resource
{
    public static function getNavigationGroup(): string
    {
        return 'Job manager';
    }

    public static function getNavigationSort(): int
    {
        return 9;
    }

    public static function getNavigationLabel(): string
    {
        return 'Github Search Batches';
    }

    protected static ?string $model = GithubSearch::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()->schema([
                Grid::make(['default' => 0])->schema([
                    TextInput::make('keyphrase')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('keyphrase')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('count')
                        ->rules(['numeric'])
                        ->required()
                        ->numeric()
                        ->placeholder('count')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('pages')
                        ->rules(['numeric'])
                        ->required()
                        ->numeric()
                        ->placeholder('pages')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('nextpage')
                        ->rules(['numeric'])
                        ->required()
                        ->numeric()
                        ->placeholder('nextpage')
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
                Tables\Columns\TextColumn::make('keyphrase')
                    ->toggleable()
                    ->sortable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('count')
                    ->toggleable()
                    ->sortable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('pages')
                    ->toggleable()
                    ->sortable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('nextpage')
                    ->sortable()
                    ->toggleable()
                    ->searchable(true, null, true),
            ])
            ->filters([DateRangeFilter::make('created_at')])
            ->actions([ViewAction::make(), EditAction::make()])
            ->bulkActions([DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGithubSearches::route('/'),
            'create' => Pages\CreateGithubSearch::route('/create'),
            'view' => Pages\ViewGithubSearch::route('/{record}'),
            'edit' => Pages\EditGithubSearch::route('/{record}/edit'),
        ];
    }
}
