<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'latest_version',
        'versions',
        'vendor_id',
        'itemType_id',
        'website',
        'popularity',
        'rating',
        'rating_data',
        'health',
        'health_data',
        'github_url',
        'github_stars',
        'packagist_url',
        'packagist_name',
        'packagist_description',
        'packagist_downloads',
        'packagist_favers',
        'npm_url',
        'github_maintainers',
        'github_repo_id',
        'npm_package_id',
        'packagist_package_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'versions' => 'array',
        'rating_data' => 'array',
        'health_data' => 'array',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function githubRepo()
    {
        return $this->belongsTo(GithubRepo::class);
    }

    public function npmPackage()
    {
        return $this->belongsTo(NpmPackage::class);
    }

    public function packagistPackage()
    {
        return $this->belongsTo(PackagistPackage::class);
    }

    public function itemType()
    {
        return $this->belongsTo(ItemType::class, 'itemType_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function platforms()
    {
        return $this->belongsToMany(Platform::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function stacks()
    {
        return $this->belongsToMany(Stack::class);
    }

    public function dependencies()
    {
        return $this->belongsToMany(
            Item::class,
            'item_item',
            'item_id',
            'dep_item_id'
        );
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_item', 'dep_item_id');
    }
}
