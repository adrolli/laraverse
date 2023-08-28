<?php

namespace App\Filament\Resources\PackagistPackageResource\Pages;

use App\Filament\Resources\PackagistPackageResource;
use App\Filament\Traits\HasDescendingOrder;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPackagistPackages extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = PackagistPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];

    }

    protected function getTableQuery(): Builder
    {
        return static::getResource()::getEloquentQuery()->select('id', 'title', 'slug', 'type', 'repository_updated');
    }
}
