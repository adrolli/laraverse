<?php

namespace App\Filament\Resources\PostTypeResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\PostTypeResource;

class ListPostTypes extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = PostTypeResource::class;
}
