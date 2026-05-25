<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supervisions', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->string('student_identifier')->nullable();
            $table->string('project_title');
            $table->string('program')->nullable();
            $table->string('academic_year')->nullable();
            $table->enum('type', ['final_project', 'thesis', 'internship', 'research', 'competition'])->default('final_project');
            $table->enum('status', ['ongoing', 'completed'])->default('ongoing');
            $table->text('description')->nullable();
            $table->string('result_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supervisions');
    }
};
