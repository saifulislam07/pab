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
            $table->enum('membership_type', ['yearly', 'lifetime', 'none'])->default('none');
            $table->enum('membership_status', ['none', 'pending', 'active', 'expired'])->default('none');
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_proof')->nullable();
            $table->timestamp('membership_started_at')->nullable();
            $table->timestamp('membership_expires_at')->nullable();
        });
    }

    public function down(): void {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn([
                'membership_type',
                'membership_status',
                'payment_method',
                'transaction_id',
                'payment_proof',
                'membership_started_at',
                'membership_expires_at',
            ]);
        });
    }
};
