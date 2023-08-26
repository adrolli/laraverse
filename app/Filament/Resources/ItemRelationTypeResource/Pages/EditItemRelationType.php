<?php

namespace App\Filament\Resources\ItemRelationTypeResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ItemRelationTypeResource;

class EditItemRelationType extends EditRecord
{
    protected static string $resource = ItemRelationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
