<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostType extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['title', 'slug', 'description'];

    protected $searchableFields = ['*'];

    protected $table = 'post_types';

    public function comments()
    {
        return $this->hasMany(Post::class, 'post_type_id');
    }
}
