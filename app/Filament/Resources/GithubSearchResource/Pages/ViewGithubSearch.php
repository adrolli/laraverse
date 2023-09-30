<?php

namespace App\Filament\Resources\GithubSearchResource\Pages;

use App\Filament\Resources\GithubSearchResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGithubSearch extends ViewRecord
{
    protected static string $resource = GithubSearchResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make(), DeleteAction::make()];
    }
}
