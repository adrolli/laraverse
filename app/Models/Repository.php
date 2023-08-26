<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Repository extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'license',
        'readme',
        'data',
        'composer',
        'npm',
        'code_analyzer',
        'package_type',
        'repository_type_id',
        'organization_id',
        'owner_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'data' => 'array',
        'composer' => 'array',
        'npm' => 'array',
        'code_analyzer' => 'array',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function repositoryType()
    {
        return $this->belongsTo(RepositoryType::class);
    }

    public function repositoryTags()
    {
        return $this->belongsToMany(
            RepositoryTag::class,
            'repository_tag',
            'repository_id',
            'repo_tag_id'
        );
    }
}
