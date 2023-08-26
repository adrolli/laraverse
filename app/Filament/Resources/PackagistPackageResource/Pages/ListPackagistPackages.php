<?php

namespace App\Filament\Resources\PackagistPackageResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\PackagistPackageResource;

class ListPackagistPackages extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = PackagistPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
