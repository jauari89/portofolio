<?php

namespace App\Models;

use App\Models\Concerns\HasActiveScope;
use App\Models\Concerns\HasOrderedScope;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasActiveScope;
    use HasOrderedScope;

    protected $fillable = [
        'authors',
        'title',
        'year',
        'publisher',
        'journal_or_conference',
        'doi',
        'url',
        'abstract',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
