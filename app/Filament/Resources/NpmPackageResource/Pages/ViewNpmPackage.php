<?php

namespace App\Filament\Resources\NpmPackageResource\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\NpmPackageResource;

class ViewNpmPackage extends ViewRecord
{
    protected static string $resource = NpmPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make(), DeleteAction::make()];
    }
}
