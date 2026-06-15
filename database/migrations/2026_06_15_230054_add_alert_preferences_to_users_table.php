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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('alert_email_enabled')->default(true)->after('email');
            $table->string('alert_email_address')->nullable()->after('alert_email_enabled');
            $table->boolean('alert_telegram_enabled')->default(false)->after('alert_email_address');
            $table->string('alert_telegram_chat_id', 80)->nullable()->after('alert_telegram_enabled');
            $table->boolean('alert_notify_offline')->default(true)->after('alert_telegram_chat_id');
            $table->boolean('alert_notify_recovery')->default(true)->after('alert_notify_offline');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'alert_email_enabled',
                'alert_email_address',
                'alert_telegram_enabled',
                'alert_telegram_chat_id',
                'alert_notify_offline',
                'alert_notify_recovery',
            ]);
        });
    }
};
