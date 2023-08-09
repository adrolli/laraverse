<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GithubRepo extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'slug',
        'data',
        'github_organization_id',
        'github_owner_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'github_repos';

    protected $casts = [
        'data' => 'array',
    ];

    public function githubOrganization()
    {
        return $this->belongsTo(GithubOrganization::class);
    }

    public function githubOwner()
    {
        return $this->belongsTo(GithubOwner::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function githubTags()
    {
        return $this->belongsToMany(GithubTag::class);
    }
}
