<?php

namespace App\Filament\Resources\ItemRelationResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\ItemRelationResource;

class ListItemRelations extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = ItemRelationResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
