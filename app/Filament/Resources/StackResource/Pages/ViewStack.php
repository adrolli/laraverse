<?php

namespace App\Filament\Resources\StackResource\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\StackResource;

class ViewStack extends ViewRecord
{
    protected static string $resource = StackResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make(), DeleteAction::make()];
    }
}
