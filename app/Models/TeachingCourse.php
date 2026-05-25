<?php

namespace App\Models;

use App\Models\Concerns\HasActiveScope;
use App\Models\Concerns\HasOrderedScope;
use Illuminate\Database\Eloquent\Model;

class TeachingCourse extends Model
{
    use HasActiveScope;
    use HasOrderedScope;

    protected $fillable = [
        'course_name',
        'course_code',
        'semester',
        'academic_year',
        'description',
        'material_url',
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
