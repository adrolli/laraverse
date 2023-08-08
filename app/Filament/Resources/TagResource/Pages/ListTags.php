<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;

class ListTags extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = TagResource::class;
}
