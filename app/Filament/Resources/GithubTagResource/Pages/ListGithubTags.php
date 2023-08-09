<?php

namespace App\Filament\Resources\GithubTagResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\GithubTagResource;

class ListGithubTags extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = GithubTagResource::class;
}
