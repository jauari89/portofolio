<?php

namespace App\Models;

use App\Models\Concerns\HasActiveScope;
use App\Models\Concerns\HasOrderedScope;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasActiveScope;
    use HasOrderedScope;

    protected $fillable = [
        'name',
        'category',
        'percentage',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'percentage' => 'integer',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
