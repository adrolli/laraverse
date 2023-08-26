<?php

namespace App\Filament\Resources\OrganizationResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\OrganizationResource;

class ListOrganizations extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = OrganizationResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
