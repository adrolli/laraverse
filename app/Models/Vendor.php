<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'slug',
        'github',
        'packagist',
        'npm',
        'website',
        'description',
    ];

    protected $searchableFields = ['*'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
