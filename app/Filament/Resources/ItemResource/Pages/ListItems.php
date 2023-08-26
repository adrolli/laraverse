<?php

namespace App\Filament\Resources\ItemResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\ItemResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;

class ListItems extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
