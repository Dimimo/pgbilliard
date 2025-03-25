<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id')->index();
            $table->foreignId('player_id')->index();
            $table->foreignId('user_id')->index();
            $table->unsignedTinyInteger('max_games')->comment('total of days played');
            $table->unsignedTinyInteger('participated')->comment('participated days played');
            $table->unsignedTinyInteger('won');
            $table->unsignedTinyInteger('lost');
            $table->unsignedTinyInteger('played')->comment('sum of won and lost');
            $table->unsignedTinyInteger('percentage')->index()->comment('defines the ranking');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ranks');
    }
};
