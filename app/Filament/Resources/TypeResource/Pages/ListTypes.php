<?php

namespace App\Filament\Resources\TypeResource\Pages;

use App\Filament\Resources\TypeResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;

class ListTypes extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = TypeResource::class;
}
