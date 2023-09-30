<?php

namespace App\Filament\Resources\RepositorySourceResource\Pages;

use App\Filament\Resources\RepositorySourceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRepositorySource extends ViewRecord
{
    protected static string $resource = RepositorySourceResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make(), DeleteAction::make()];
    }
}
