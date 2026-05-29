<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teaching_courses', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('course_name');
            $table->longText('overview')->nullable()->after('description');
            $table->longText('materials')->nullable()->after('material_url');
            $table->string('rps_file')->nullable()->after('materials');
            $table->string('rps_url')->nullable()->after('rps_file');
            $table->longText('rps_summary')->nullable()->after('rps_url');
            $table->longText('sample_projects')->nullable()->after('rps_summary');
        });

        $usedSlugs = [];

        DB::table('teaching_courses')
            ->select(['id', 'course_name'])
            ->orderBy('id')
            ->get()
            ->each(function (object $course) use (&$usedSlugs): void {
                $baseSlug = Str::slug($course->course_name) ?: 'mata-kuliah';
                $slug = $baseSlug;
                $counter = 2;

                while (in_array($slug, $usedSlugs, true)) {
                    $slug = $baseSlug.'-'.$counter++;
                }

                $usedSlugs[] = $slug;

                DB::table('teaching_courses')
                    ->where('id', $course->id)
                    ->update(['slug' => $slug]);
            });

        Schema::table('teaching_courses', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::table('teaching_courses', function (Blueprint $table) {
            $table->dropUnique('teaching_courses_slug_unique');
            $table->dropColumn([
                'slug',
                'overview',
                'materials',
                'rps_file',
                'rps_url',
                'rps_summary',
                'sample_projects',
            ]);
        });
    }
};
