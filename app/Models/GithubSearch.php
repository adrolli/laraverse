<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GithubSearch extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'keyphrase',
        'count',
        'pages',
        'nextpage',
    ];

    protected $searchableFields = ['*'];
}
