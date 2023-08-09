<?php

namespace App\Filament\Resources\NpmPackageResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\NpmPackageResource;

class ListNpmPackages extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = NpmPackageResource::class;
}
