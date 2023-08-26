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
        'ranking',
        'popularity',
        'popularity_data',
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
        'php_compatibility',
        'laravel_compatibilty',
        'repository_id',
        'npm_package_id',
        'packagist_package_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'versions' => 'array',
        'popularity_data' => 'array',
        'rating_data' => 'array',
        'health_data' => 'array',
        'php_compatibility' => 'array',
        'laravel_compatibilty' => 'array',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
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

    public function repository()
    {
        return $this->belongsTo(Repository::class);
    }

    public function itemRelationsTo()
    {
        return $this->hasMany(ItemRelation::class, 'itemto_id');
    }

    public function itemRelations()
    {
        return $this->hasMany(ItemRelation::class);
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
}
