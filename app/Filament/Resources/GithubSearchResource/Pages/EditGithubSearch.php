<?php

namespace App\Filament\Resources\GithubSearchResource\Pages;

use App\Filament\Resources\GithubSearchResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGithubSearch extends EditRecord
{
    protected static string $resource = GithubSearchResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
