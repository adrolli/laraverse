<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GithubOrganization extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['title', 'slug', 'data'];

    protected $searchableFields = ['*'];

    protected $table = 'github_organizations';

    protected $casts = [
        'data' => 'array',
    ];

    public function githubRepos()
    {
        return $this->hasMany(GithubRepo::class);
    }
}
