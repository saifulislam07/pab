<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('members', function (Blueprint $table) {
            $table->string('title')->nullable()->after('name');
            $table->string('division')->nullable()->after('bio');
            $table->string('district')->nullable()->after('division');
            $table->string('upazila')->nullable()->after('district');
            $table->string('current_location')->nullable()->after('upazila');
            $table->string('specialization')->nullable()->after('current_location');
            $table->string('experience_level')->nullable()->after('specialization');
            $table->text('camera_gear')->nullable()->after('experience_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'division',
                'district',
                'upazila',
                'current_location',
                'specialization',
                'experience_level',
                'camera_gear',
            ]);
        });
    }
};
