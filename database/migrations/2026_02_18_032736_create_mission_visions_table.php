<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('mission_visions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();

            // Mission
            $table->string('mission_title')->nullable();
            $table->text('mission_description')->nullable();
            $table->json('mission_points')->nullable();
            $table->string('mission_image')->nullable();

            // Vision
            $table->string('vision_title')->nullable();
            $table->text('vision_description')->nullable();
            $table->json('vision_points')->nullable();
            $table->string('vision_image')->nullable();

            // Core Values
            $table->json('core_values')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('mission_visions');
    }
};
