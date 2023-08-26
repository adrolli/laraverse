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
        'avatar',
        'description',
        'email',
        'website',
        'github',
        'packagist',
        'npm',
        'owner_id',
        'organization_id',
    ];

    protected $searchableFields = ['*'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}
