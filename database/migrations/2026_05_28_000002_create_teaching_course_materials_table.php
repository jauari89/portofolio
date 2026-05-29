<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teaching_course_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teaching_course_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('week_number');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('pdf_file')->nullable();
            $table->string('material_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['teaching_course_id', 'week_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teaching_course_materials');
    }
};
