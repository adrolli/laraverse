<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\CategoryResource;

class ListCategories extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = CategoryResource::class;
}
