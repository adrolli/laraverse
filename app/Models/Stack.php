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
        'build',
        'public',
        'major',
        'user_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'build' => 'array',
        'public' => 'boolean',
        'major' => 'boolean',
    ];

    public function comments()
    {
        return $this->hasMany(Post::class, 'stack_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
