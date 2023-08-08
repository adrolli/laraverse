<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Version extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['version', 'item_id'];

    protected $searchableFields = ['*'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function dependencies()
    {
        return $this->belongsToMany(
            Version::class,
            'version_version',
            'dep_version_id'
        );
    }

    public function versions()
    {
        return $this->belongsToMany(
            Version::class,
            'version_version',
            'version_id',
            'dep_version_id'
        );
    }
}
