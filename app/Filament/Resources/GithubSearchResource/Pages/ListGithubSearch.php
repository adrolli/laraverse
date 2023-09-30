<?php

namespace App\Filament\Resources\GithubSearchResource\Pages;

use App\Filament\Resources\GithubSearchResource;
use App\Filament\Traits\HasDescendingOrder;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGithubSearches extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = GithubSearchResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
