<?php

namespace App\Filament\Resources;

use App\Models\PostType;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\PostTypeResource\Pages;

class PostTypeResource extends Resource
{
    protected static ?string $model = PostType::class;

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
                        ->nullable()
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
            ])
            ->filters([DateRangeFilter::make('created_at')]);
    }

    public static function getRelations(): array
    {
        return [PostTypeResource\RelationManagers\PostsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPostTypes::route('/'),
            'create' => Pages\CreatePostType::route('/create'),
            'view' => Pages\ViewPostType::route('/{record}'),
            'edit' => Pages\EditPostType::route('/{record}/edit'),
        ];
    }
}