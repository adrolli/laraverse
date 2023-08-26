<?php

namespace App\Filament\Resources\RepositoryTagResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\RepositoryTagResource;

class ListRepositoryTags extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = RepositoryTagResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
