<?php

namespace App\Filament\Resources\PackagistPackageResource\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\PackagistPackageResource;

class ViewPackagistPackage extends ViewRecord
{
    protected static string $resource = PackagistPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make(), DeleteAction::make()];
    }
}
