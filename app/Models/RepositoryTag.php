<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepositoryTag extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['title', 'slug', 'weight'];

    protected $searchableFields = ['*'];

    protected $table = 'repository_tags';

    public function repositories()
    {
        return $this->belongsToMany(
            Repository::class,
            'repository_tag',
            'repo_tag_id'
        );
    }
}
