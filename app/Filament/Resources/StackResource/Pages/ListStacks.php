<?php

namespace App\Filament\Resources\StackResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\StackResource;
use App\Filament\Traits\HasDescendingOrder;

class ListStacks extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = StackResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
