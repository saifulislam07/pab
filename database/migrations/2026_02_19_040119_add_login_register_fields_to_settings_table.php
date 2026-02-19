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
            $table->string('login_title')->nullable()->after('linkedin_link');
            $table->text('login_description')->nullable()->after('login_title');
            $table->string('login_feature_1')->nullable()->after('login_description');
            $table->string('login_feature_2')->nullable()->after('login_feature_1');
            $table->string('login_feature_3')->nullable()->after('login_feature_2');
            $table->string('register_title')->nullable()->after('login_feature_3');
            $table->text('register_description')->nullable()->after('register_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'login_title',
                'login_description',
                'login_feature_1',
                'login_feature_2',
                'login_feature_3',
                'register_title',
                'register_description',
            ]);
        });
    }
};
