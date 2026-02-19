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
            $table->text('footer_copyright')->nullable()->after('footer_text');
        });

        // Migrate existing footer_text to footer_copyright if it contains copyright symbols
        $setting = \App\Models\Setting::first();
        if ($setting && $setting->footer_text && (str_contains($setting->footer_text, '©') || str_contains($setting->footer_text, 'Copyright'))) {
            $setting->update([
                'footer_copyright' => $setting->footer_text,
                'footer_text'      => 'Uniting photographers, inspiring creativity, and capturing the essence of Bangladesh. Join our community to explore the art of visual storytelling.',
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('footer_copyright');
        });
    }
};
