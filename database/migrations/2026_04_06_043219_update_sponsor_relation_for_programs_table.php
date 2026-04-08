<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Try to drop the foreign key safely
        try {
            Schema::table('programs', function (Blueprint $table) {
                $table->dropForeign(['sponsor_id']);
            });
        } catch (\Exception $e) {
            // Ignore if foreign key doesn't exist
        }

        // 2. Try to drop the column safely
        if (Schema::hasColumn('programs', 'sponsor_id')) {
            Schema::table('programs', function (Blueprint $table) {
                $table->dropColumn('sponsor_id');
            });
        }

        Schema::create('program_sponsor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->foreignId('sponsor_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_sponsor');

        Schema::table('programs', function (Blueprint $table) {
            $table->foreignId('sponsor_id')->nullable()->constrained('sponsors')->nullOnDelete();
        });
    }
};
