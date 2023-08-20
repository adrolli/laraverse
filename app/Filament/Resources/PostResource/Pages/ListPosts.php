<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;

class ListPosts extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = PostResource::class;
}
