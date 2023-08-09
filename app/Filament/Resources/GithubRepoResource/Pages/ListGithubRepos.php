<?php

namespace App\Filament\Resources\GithubRepoResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\GithubRepoResource;

class ListGithubRepos extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = GithubRepoResource::class;
}
