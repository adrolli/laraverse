<?php

namespace App\Filament\Resources\PlatformResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\PlatformResource;

class ListPlatforms extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = PlatformResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
