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
            $table->string('register_feature_1')->nullable()->after('register_description');
            $table->string('register_feature_2')->nullable()->after('register_feature_1');
            $table->string('register_feature_3')->nullable()->after('register_feature_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'register_feature_1',
                'register_feature_2',
                'register_feature_3',
            ]);
        });
    }
};
