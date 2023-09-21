<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class PackagistPackage extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'slug',
        'data',
        'type',
        'repository_updated',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'packagist_packages';

    protected $casts = [
        'data' => 'array',
        'repository_updated' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
        ];
    }
}
