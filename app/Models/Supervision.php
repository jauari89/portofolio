<?php

namespace App\Models;

use App\Models\Concerns\HasActiveScope;
use App\Models\Concerns\HasOrderedScope;
use Illuminate\Database\Eloquent\Model;

class Supervision extends Model
{
    use HasActiveScope;
    use HasOrderedScope;

    protected $fillable = [
        'student_name',
        'student_identifier',
        'project_title',
        'program',
        'academic_year',
        'type',
        'status',
        'description',
        'result_url',
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
