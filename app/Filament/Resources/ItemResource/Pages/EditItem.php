<?php

namespace App\Filament\Resources\ItemResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\ItemResource;
use Filament\Resources\Pages\EditRecord;

class EditItem extends EditRecord
{
    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
