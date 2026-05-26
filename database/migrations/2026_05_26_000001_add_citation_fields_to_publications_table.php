<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->string('volume')->nullable()->after('journal_or_conference');
            $table->string('issue')->nullable()->after('volume');
            $table->string('pages')->nullable()->after('issue');
        });
    }

    public function down(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->dropColumn(['volume', 'issue', 'pages']);
        });
    }
};
