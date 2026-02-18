<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('sponsor_title')->nullable()->after('linkedin_link');
            $table->string('sponsor_subtitle')->nullable()->after('sponsor_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['sponsor_title', 'sponsor_subtitle']);
        });
    }
};
