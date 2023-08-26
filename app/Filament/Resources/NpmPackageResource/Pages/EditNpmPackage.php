<?php

namespace App\Filament\Resources\NpmPackageResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\NpmPackageResource;

class EditNpmPackage extends EditRecord
{
    protected static string $resource = NpmPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
