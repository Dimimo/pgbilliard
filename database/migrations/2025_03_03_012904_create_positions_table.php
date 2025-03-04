<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id');
            $table->foreignId('player_id');
            $table->unsignedTinyInteger('rank');
            $table->boolean('home');
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('player_id')->references('id')->on('players');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
