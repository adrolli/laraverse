<?php

namespace App\Filament\Resources\GithubRepoResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\GithubRepoResource;

class CreateGithubRepo extends CreateRecord
{
    protected static string $resource = GithubRepoResource::class;
}
