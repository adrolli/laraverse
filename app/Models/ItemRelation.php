<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemRelation extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'data',
        'item_id',
        'item_relation_type_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'item_relations';

    protected $casts = [
        'data' => 'array',
    ];

    public function itemFrom()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function itemTo()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function itemRelationType()
    {
        return $this->belongsTo(ItemRelationType::class);
    }
}
