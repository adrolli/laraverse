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
        'itemto_id',
        'item_relation_type_id',
        'post_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'item_relations';

    protected $casts = [
        'data' => 'array',
    ];

    public function itemRelationType()
    {
        return $this->belongsTo(ItemRelationType::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function itemTo()
    {
        return $this->belongsTo(Item::class, 'itemto_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
