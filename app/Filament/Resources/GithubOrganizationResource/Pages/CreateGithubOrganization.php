<?php

namespace App\Filament\Resources\GithubOrganizationResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\GithubOrganizationResource;

class CreateGithubOrganization extends CreateRecord
{
    protected static string $resource = GithubOrganizationResource::class;
}
