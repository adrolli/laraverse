<?php

namespace App\Filament\Resources\RepositorySourceResource\Pages;

use App\Filament\Resources\RepositorySourceResource;
use App\Filament\Traits\HasDescendingOrder;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRepositorySources extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = RepositorySourceResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
