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
        'created_by',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
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
