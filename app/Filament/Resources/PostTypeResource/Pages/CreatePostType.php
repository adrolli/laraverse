<?php

namespace App\Filament\Resources\PostTypeResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PostTypeResource;

class CreatePostType extends CreateRecord
{
    protected static string $resource = PostTypeResource::class;
}
