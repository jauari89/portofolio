<?php

namespace App\Models;

use App\Models\Concerns\HasActiveScope;
use App\Models\Concerns\HasOrderedScope;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasActiveScope;
    use HasOrderedScope;

    protected $fillable = [
        'type',
        'title',
        'institution',
        'location',
        'start_year',
        'end_year',
        'description',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'start_year' => 'integer',
            'end_year' => 'integer',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
