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
        if (! Schema::hasTable('events')) {
            Schema::create('events', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('date_id')->index();
                $table->unsignedBigInteger('venue_id')->index();
                $table->unsignedBigInteger('team1')->index();
                $table->unsignedBigInteger('team2')->index();
                $table->unsignedSmallInteger('score1')->nullable()->index();
                $table->unsignedSmallInteger('score2')->nullable()->index();
                $table->text('remark')->nullable();
                $table->timestamps();

                $table->foreign('date_id')
                    ->references('id')
                    ->on('dates')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
                $table
                    ->foreign('venue_id')
                    ->references('id')
                    ->on('venues')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
