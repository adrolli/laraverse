<?php

namespace App\Filament\Resources\RepositoryTagResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\RepositoryTagResource;

class EditRepositoryTag extends EditRecord
{
    protected static string $resource = RepositoryTagResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
