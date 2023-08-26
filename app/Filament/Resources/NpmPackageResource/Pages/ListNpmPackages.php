<?php

namespace App\Filament\Resources\NpmPackageResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\NpmPackageResource;

class ListNpmPackages extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = NpmPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
