<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['title', 'slug', 'data'];

    protected $searchableFields = ['*'];

    protected $casts = [
        'data' => 'array',
    ];

    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }

    public function repositories()
    {
        return $this->hasMany(Repository::class);
    }
}
