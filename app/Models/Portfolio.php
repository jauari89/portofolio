<?php

namespace App\Models;

use App\Models\Concerns\HasOrderedScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    use HasOrderedScope;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'short_description',
        'content',
        'thumbnail',
        'year',
        'client_or_institution',
        'demo_url',
        'repository_url',
        'status',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Portfolio $portfolio) {
            if ($portfolio->isDirty('title') || $portfolio->isDirty('slug') || blank($portfolio->slug)) {
                $portfolio->slug = static::uniqueSlug($portfolio);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    private static function uniqueSlug(Portfolio $portfolio): string
    {
        $base = Str::slug($portfolio->slug ?: $portfolio->title) ?: 'portfolio';
        $slug = $base;
        $counter = 2;

        while (static::withTrashed()
            ->where('slug', $slug)
            ->when($portfolio->exists, fn (Builder $query) => $query->where('id', '!=', $portfolio->id))
            ->exists()) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
