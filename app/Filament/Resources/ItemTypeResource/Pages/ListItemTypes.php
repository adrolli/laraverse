<?php

namespace App\Filament\Resources\ItemTypeResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\ItemTypeResource;

class ListItemTypes extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = ItemTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
