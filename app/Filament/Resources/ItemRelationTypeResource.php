<?php

namespace App\Filament\Resources;

use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\ItemRelationTypeResource\Pages;
use App\Models\ItemRelationType;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ItemRelationTypeResource extends Resource
{
    protected static ?string $model = ItemRelationType::class;

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

                    RichEditor::make('description')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Description')
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
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('slug')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('description')
                    ->html()
                    ->toggleable()
                    ->searchable()
                    ->label('Short'),
            ])
            ->filters([DateRangeFilter::make('created_at')]);
    }

    public static function getRelations(): array
    {
        return [
            ItemRelationTypeResource\RelationManagers\ItemRelationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItemRelationTypes::route('/'),
            'create' => Pages\CreateItemRelationType::route('/create'),
            'view' => Pages\ViewItemRelationType::route('/{record}'),
            'edit' => Pages\EditItemRelationType::route('/{record}/edit'),
        ];
    }
}
