<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['title', 'slug', 'data', 'ghid', 'avatar', 'gravatar'];

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
