<?php

namespace App\Filament\Resources\RepositoryResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\RepositoryResource;

class ListRepositories extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = RepositoryResource::class;
}
