<?php

namespace App\Filament\Resources\ItemRelationTypeResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\ItemRelationTypeResource;

class ListItemRelationTypes extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = ItemRelationTypeResource::class;
}
