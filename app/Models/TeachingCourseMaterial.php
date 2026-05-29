<?php

namespace App\Models;

use App\Models\Concerns\HasActiveScope;
use App\Models\Concerns\HasOrderedScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeachingCourseMaterial extends Model
{
    use HasActiveScope;
    use HasOrderedScope;

    protected $fillable = [
        'teaching_course_id',
        'week_number',
        'title',
        'description',
        'pdf_file',
        'material_url',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'week_number' => 'integer',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(TeachingCourse::class, 'teaching_course_id');
    }

    protected function courseLabel(): Attribute
    {
        return Attribute::get(fn () => $this->course?->course_name ?? '-');
    }

    protected function hasPdf(): Attribute
    {
        return Attribute::get(fn () => filled($this->pdf_file) || filled($this->material_url));
    }
}
