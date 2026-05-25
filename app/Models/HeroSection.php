<?php

namespace App\Models;

use App\Models\Concerns\HasActiveScope;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasActiveScope;

    protected $fillable = [
        'headline',
        'subheadline',
        'description',
        'background_image',
        'primary_button_text',
        'primary_button_url',
        'secondary_button_text',
        'secondary_button_url',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public static function current(): self
    {
        return static::query()->active()->first()
            ?? static::query()->firstOrCreate([
                'headline' => 'I am Jauari',
            ], [
                'subheadline' => 'Lecturer, Software Engineer',
                'description' => 'Building academic technology, web platforms, and multimedia learning experiences.',
                'primary_button_text' => 'View Portfolio',
                'primary_button_url' => '#portfolio',
                'secondary_button_text' => 'Contact Me',
                'secondary_button_url' => '#contact',
                'is_active' => true,
            ]);
    }
}
