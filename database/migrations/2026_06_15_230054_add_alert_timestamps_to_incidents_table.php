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
        Schema::table('incidents', function (Blueprint $table) {
            $table->timestamp('offline_email_sent_at')->nullable()->after('status');
            $table->timestamp('recovery_email_sent_at')->nullable()->after('offline_email_sent_at');
            $table->timestamp('offline_telegram_sent_at')->nullable()->after('recovery_email_sent_at');
            $table->timestamp('recovery_telegram_sent_at')->nullable()->after('offline_telegram_sent_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropColumn([
                'offline_email_sent_at',
                'recovery_email_sent_at',
                'offline_telegram_sent_at',
                'recovery_telegram_sent_at',
            ]);
        });
    }
};
