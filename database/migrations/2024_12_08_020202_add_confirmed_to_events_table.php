<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->after('score2', function (Blueprint $table) {
                $table->boolean('confirmed')->default(false)->index();
            });
        });

        \Illuminate\Support\Facades\DB::table('events')
            ->whereNotNull(['score1', 'score2'])
            ->where([['score1', '<>', '0'], ['score2', '<>', '0']])
            ->update(['confirmed' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('confirmed');
        });
    }
};
