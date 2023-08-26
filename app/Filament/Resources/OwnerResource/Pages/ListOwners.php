<?php

namespace App\Filament\Resources\OwnerResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\OwnerResource;
use App\Filament\Traits\HasDescendingOrder;

class ListOwners extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = OwnerResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
