<?php

namespace App\Filament\Resources\RepositoryTypeResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\RepositoryTypeResource;

class EditRepositoryType extends EditRecord
{
    protected static string $resource = RepositoryTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
