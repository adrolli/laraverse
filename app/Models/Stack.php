<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stack extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'public',
        'major',
        'user_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'public' => 'boolean',
        'major' => 'boolean',
    ];

    public function created_by()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
