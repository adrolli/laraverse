<?php

namespace App\Filament\Resources\VersionResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\VersionResource;

class ListVersions extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = VersionResource::class;
}
