<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->string('name');
            $table->boolean('personal_team');
            $table->timestamps();
        });

        Schema::create('team_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id');
            $table->foreignId('user_id');
            $table->string('role')->nullable();
            $table->timestamps();

            $table->unique(['team_id', 'user_id']);
        });

        Schema::create('team_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->string('email');
            $table->string('role')->nullable();
            $table->timestamps();

            $table->unique(['team_id', 'email']);
        });

        Schema::table('monitors', function (Blueprint $table) {
            $table->foreignId('team_id')
                ->nullable()
                ->after('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->index(['team_id', 'status']);
            $table->index(['team_id', 'type']);
        });

        DB::table('users')
            ->orderBy('id')
            ->select(['id', 'name'])
            ->chunk(100, function ($users) {
                foreach ($users as $user) {
                    $teamId = DB::table('teams')->insertGetId([
                        'user_id' => $user->id,
                        'name' => Str::before($user->name, ' ')."'s Team",
                        'personal_team' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['current_team_id' => $teamId]);

                    DB::table('monitors')
                        ->where('user_id', $user->id)
                        ->whereNull('team_id')
                        ->update(['team_id' => $teamId]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('monitors', function (Blueprint $table) {
            $table->dropIndex(['team_id', 'status']);
            $table->dropIndex(['team_id', 'type']);
            $table->dropConstrainedForeignId('team_id');
        });

        Schema::dropIfExists('team_invitations');
        Schema::dropIfExists('team_user');
        Schema::dropIfExists('teams');
    }
};
