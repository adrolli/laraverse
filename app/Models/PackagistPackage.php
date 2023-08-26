<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
