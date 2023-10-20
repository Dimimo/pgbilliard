<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('season_id')->index();
            $table->date('date');
            $table->boolean('regular')->default(false)->index();
            $table->string('title', 48)->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();

            $table->foreign('season_id')->references('id')->on('seasons');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dates');
    }
};
