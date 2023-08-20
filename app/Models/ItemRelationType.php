<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemRelationType extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['title', 'slug', 'description'];

    protected $searchableFields = ['*'];

    protected $table = 'item_relation_types';

    public function itemRelations()
    {
        return $this->hasMany(ItemRelation::class);
    }
}
