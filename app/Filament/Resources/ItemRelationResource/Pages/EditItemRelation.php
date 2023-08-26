<?php

namespace App\Filament\Resources\ItemRelationResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ItemRelationResource;

class EditItemRelation extends EditRecord
{
    protected static string $resource = ItemRelationResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
