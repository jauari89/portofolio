<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileSection extends Model
{
    protected $fillable = [
        'full_name',
        'professional_title',
        'short_description',
        'long_description',
        'location',
        'primary_email',
        'secondary_email',
        'phone',
        'profile_photo',
        'birthdate',
    ];

    protected function casts(): array
    {
        return [
            'birthdate' => 'date',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrCreate([
            'full_name' => 'Jauari Akhmad Nur Hasim',
        ], [
            'professional_title' => 'Lecturer, Software Engineer',
            'short_description' => 'Lecturer and software engineer focused on web technology, multimedia systems, and academic supervision.',
            'location' => 'Surabaya, Jawa Timur',
            'primary_email' => 'jauari@pens.ac.id',
            'secondary_email' => 'jauarifar@gmail.com',
        ]);
    }
}
