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
        'vendor_id',
        'type_id',
        'website',
        'rating',
        'health',
        'github_url',
        'github_stars',
        'github_forks',
        'github_json',
        'packagist_url',
        'packagist_name',
        'packagist_description',
        'packagist_downloads',
        'packagist_favers',
        'npm_url',
        'github_maintainers',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'github_json' => 'array',
    ];

    public function versions()
    {
        return $this->hasMany(Version::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
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
