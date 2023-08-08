<?php

namespace App\Filament\Resources\PlatformResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\PlatformResource;

class ListPlatforms extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = PlatformResource::class;
}
