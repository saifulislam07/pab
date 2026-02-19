<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('team_members', function (Blueprint $table) {
            $table->string('instagram')->nullable()->after('facebook');
            $table->string('website')->nullable()->after('linkedin');
            $table->dropColumn('twitter');
        });
    }

    public function down(): void {
        Schema::table('team_members', function (Blueprint $table) {
            $table->string('twitter')->nullable()->after('facebook');
            $table->dropColumn(['instagram', 'website']);
        });
    }
};
