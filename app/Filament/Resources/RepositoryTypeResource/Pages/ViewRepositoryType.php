<?php

namespace App\Filament\Resources\RepositoryTypeResource\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\RepositoryTypeResource;

class ViewRepositoryType extends ViewRecord
{
    protected static string $resource = RepositoryTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make(), DeleteAction::make()];
    }
}
