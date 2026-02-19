<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('members', function (Blueprint $table) {
            $table->string('profession')->nullable()->after('title');
        });
    }

    public function down(): void {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('profession');
        });
    }
};
