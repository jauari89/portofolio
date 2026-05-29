<?php

namespace App\Models;

use App\Models\Concerns\HasActiveScope;
use App\Models\Concerns\HasOrderedScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class TeachingCourse extends Model
{
    use HasActiveScope;
    use HasOrderedScope;

    protected $fillable = [
        'course_name',
        'slug',
        'course_code',
        'semester',
        'academic_year',
        'description',
        'overview',
        'material_url',
        'materials',
        'rps_file',
        'rps_url',
        'rps_summary',
        'sample_projects',
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

    protected static function booted(): void
    {
        static::saving(function (TeachingCourse $course) {
            if ($course->isDirty('course_name') || $course->isDirty('slug') || blank($course->slug)) {
                $course->slug = static::uniqueSlug($course);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function weeklyMaterials(): HasMany
    {
        return $this->hasMany(TeachingCourseMaterial::class)->orderBy('week_number');
    }

    private static function uniqueSlug(TeachingCourse $course): string
    {
        $base = Str::slug($course->slug ?: $course->course_name) ?: 'mata-kuliah';
        $slug = $base;
        $counter = 2;

        while (static::query()
            ->where('slug', $slug)
            ->when($course->exists, fn (Builder $query) => $query->where('id', '!=', $course->id))
            ->exists()) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
