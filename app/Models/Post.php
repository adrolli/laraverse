<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'data',
        'user_id',
        'item_id',
        'stack_id',
        'post_type_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'data' => 'array',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stack()
    {
        return $this->belongsTo(Stack::class);
    }

    public function postType()
    {
        return $this->belongsTo(PostType::class);
    }
}
