<?php

namespace App\Models;

use App\Models\Concerns\HasActiveScope;
use App\Models\Concerns\HasOrderedScope;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasActiveScope;
    use HasOrderedScope;

    protected $fillable = [
        'label',
        'value',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'integer',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
