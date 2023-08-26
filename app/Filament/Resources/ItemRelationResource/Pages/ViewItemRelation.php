<?php

namespace App\Filament\Resources\ItemRelationResource\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\ItemRelationResource;

class ViewItemRelation extends ViewRecord
{
    protected static string $resource = ItemRelationResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make(), DeleteAction::make()];
    }
}
