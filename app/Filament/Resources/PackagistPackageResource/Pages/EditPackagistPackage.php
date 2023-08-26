<?php

namespace App\Filament\Resources\PackagistPackageResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PackagistPackageResource;

class EditPackagistPackage extends EditRecord
{
    protected static string $resource = PackagistPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
