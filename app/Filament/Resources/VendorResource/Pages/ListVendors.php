<?php

namespace App\Filament\Resources\VendorResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\VendorResource;
use App\Filament\Traits\HasDescendingOrder;

class ListVendors extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = VendorResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
