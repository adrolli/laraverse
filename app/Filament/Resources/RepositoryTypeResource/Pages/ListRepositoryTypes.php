<?php

namespace App\Filament\Resources\RepositoryTypeResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\RepositoryTypeResource;

class ListRepositoryTypes extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = RepositoryTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
