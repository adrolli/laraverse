<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemType extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['title', 'slug', 'description'];

    protected $searchableFields = ['*'];

    protected $table = 'item_types';

    public function items()
    {
        return $this->hasMany(Item::class, 'itemType_id');
    }
}
