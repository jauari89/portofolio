<?php

namespace App\Models;

use App\Models\Concerns\HasActiveScope;
use App\Models\Concerns\HasOrderedScope;
use Illuminate\Database\Eloquent\Model;

class AcademicMetric extends Model
{
    use HasActiveScope;
    use HasOrderedScope;

    protected $fillable = [
        'label',
        'value',
        'suffix',
        'source_name',
        'source_url',
        'icon',
        'description',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
