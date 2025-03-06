<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->index();
            $table->foreignId('event_id')->index();
            $table->foreignId('team_id');
            $table->foreignId('player_id')->nullable()->index();
            $table->unsignedSmallInteger('position');
            $table->boolean('home');
            $table->boolean('win')->nullable()->default(null)->index();
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('team_id')->references('id')->on('teams');
            // $table->foreign('player_id')->references('id')->on('players');

            $table->index(['team_id', 'home']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
