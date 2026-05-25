<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'site_title',
        'meta_description',
        'meta_keywords',
        'logo',
        'favicon',
        'cv_file',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([
            'site_name' => 'Jauari Akhmad Nur Hasim',
        ], [
            'site_title' => 'Lecturer, Software Engineer',
        ]);
    }
}
