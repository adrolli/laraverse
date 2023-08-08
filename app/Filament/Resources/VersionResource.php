<?php

namespace App\Filament\Resources;

use App\Models\Version;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\VersionResource\Pages;

class VersionResource extends Resource
{
    protected static ?string $model = Version::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'version';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    TextInput::make('version')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Version')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('item_id')
                        ->rules(['exists:items,id'])
                        ->required()
                        ->relationship('item', 'title')
                        ->searchable()
                        ->placeholder('Item')
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
                Tables\Columns\TextColumn::make('version')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('item.title')
                    ->toggleable()
                    ->limit(50),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('item_id')
                    ->relationship('item', 'title')
                    ->indicator('Item')
                    ->multiple()
                    ->label('Item'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            VersionResource\RelationManagers\VersionsRelationManager::class,
            VersionResource\RelationManagers\VersionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVersions::route('/'),
            'create' => Pages\CreateVersion::route('/create'),
            'view' => Pages\ViewVersion::route('/{record}'),
            'edit' => Pages\EditVersion::route('/{record}/edit'),
        ];
    }
}
