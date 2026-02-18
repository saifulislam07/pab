<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('About Us');
            $table->text('description')->nullable(); // For "Our Story" paragraph 1
            $table->text('our_story')->nullable(); // For "Our Story" paragraph 2
            $table->text('mission')->nullable(); // Additional mission text if needed
            $table->string('image_main')->nullable();
            $table->string('image_secondary')->nullable();
            $table->string('stats_years')->default('15+');
            $table->string('stats_members')->default('500+');
            $table->string('stats_workshops')->default('120+');
            $table->string('stats_awards')->default('50+');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('abouts');
    }
};
