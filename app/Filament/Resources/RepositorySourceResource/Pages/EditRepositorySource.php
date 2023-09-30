<?php

namespace App\Filament\Resources\RepositorySourceResource\Pages;

use App\Filament\Resources\RepositorySourceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRepositorySource extends EditRecord
{
    protected static string $resource = RepositorySourceResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
