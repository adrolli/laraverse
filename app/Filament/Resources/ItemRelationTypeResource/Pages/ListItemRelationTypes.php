<?php

namespace App\Filament\Resources\ItemRelationTypeResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\ItemRelationTypeResource;

class ListItemRelationTypes extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = ItemRelationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
