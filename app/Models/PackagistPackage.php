<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackagistPackage extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['title', 'slug', 'data'];

    protected $searchableFields = ['*'];

    protected $table = 'packagist_packages';

    protected $casts = [
        'data' => 'array',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
