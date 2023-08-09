<?php

namespace App\Filament\Resources\GithubOrganizationResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\GithubOrganizationResource;

class ListGithubOrganizations extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = GithubOrganizationResource::class;
}
