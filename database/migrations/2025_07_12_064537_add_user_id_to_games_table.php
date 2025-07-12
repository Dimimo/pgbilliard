<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    /**
     * Run the migrations.
     * Afterward, run in sql:
     * UPDATE games, players SET games.user_id = players.user_id WHERE games.player_id = players.id;
     */
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->after('player_id', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->index();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropIndex('games_user_id_index');
        });
    }
};
