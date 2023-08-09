<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GithubTag extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['title', 'slug'];

    protected $searchableFields = ['*'];

    protected $table = 'github_tags';

    public function githubRepos()
    {
        return $this->belongsToMany(GithubRepo::class);
    }
}
