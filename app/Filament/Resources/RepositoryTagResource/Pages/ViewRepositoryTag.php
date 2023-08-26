<?php

namespace App\Filament\Resources\RepositoryTagResource\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\RepositoryTagResource;

class ViewRepositoryTag extends ViewRecord
{
    protected static string $resource = RepositoryTagResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make(), DeleteAction::make()];
    }
}
