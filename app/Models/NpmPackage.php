<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NpmPackage extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['title', 'slug', 'data'];

    protected $searchableFields = ['*'];

    protected $table = 'npm_packages';

    protected $casts = [
        'data' => 'array',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
