<?php

namespace App\Filament\Resources\ItemRelationTypeResource\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\ItemRelationTypeResource;

class ViewItemRelationType extends ViewRecord
{
    protected static string $resource = ItemRelationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make(), DeleteAction::make()];
    }
}
