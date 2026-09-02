<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('formats', function (Blueprint $table) {
            $table->unsignedSmallInteger('players')->default(4)->index()->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('formats', function (Blueprint $table) {
            $table->dropIndex('formats_players_index');
            $table->dropColumn('players');
        });
    }
};
