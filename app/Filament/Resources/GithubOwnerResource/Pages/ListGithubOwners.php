<?php

namespace App\Filament\Resources\GithubOwnerResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\GithubOwnerResource;

class ListGithubOwners extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = GithubOwnerResource::class;
}
