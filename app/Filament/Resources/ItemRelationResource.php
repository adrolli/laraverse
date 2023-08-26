<?php

namespace App\Filament\Resources;

use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\ItemRelationResource\Pages;
use App\Models\ItemRelation;
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

class ItemRelationResource extends Resource
{
    protected static ?string $model = ItemRelation::class;

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

                    KeyValue::make('data')
                        ->required()
                        ->required()
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

                    TextInput::make('itemto_id')
                        ->rules(['max:255'])
                        ->required()
                        ->placeholder('Itemto Id')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('item_relation_type_id')
                        ->rules(['exists:item_relation_types,id'])
                        ->required()
                        ->relationship('itemRelationType', 'title')
                        ->searchable()
                        ->placeholder('Item Relation Type')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('post_id')
                        ->rules(['exists:posts,id'])
                        ->nullable()
                        ->relationship('post', 'title')
                        ->searchable()
                        ->placeholder('Post')
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
                TextColumn::make('item.title')
                    ->toggleable()
                    ->limit(50),
                TextColumn::make('itemto_id')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                TextColumn::make('itemRelationType.title')
                    ->toggleable()
                    ->limit(50),
                TextColumn::make('post.title')
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

                SelectFilter::make('item_relation_type_id')
                    ->relationship('itemRelationType', 'title')
                    ->indicator('ItemRelationType')
                    ->multiple()
                    ->label('ItemRelationType'),

                SelectFilter::make('post_id')
                    ->relationship('post', 'title')
                    ->indicator('Post')
                    ->multiple()
                    ->label('Post'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItemRelations::route('/'),
            'create' => Pages\CreateItemRelation::route('/create'),
            'view' => Pages\ViewItemRelation::route('/{record}'),
            'edit' => Pages\EditItemRelation::route('/{record}/edit'),
        ];
    }
}
