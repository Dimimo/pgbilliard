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
        Schema::create(config('pool-forum.table_names.posts'), function (Blueprint $table) {
            $table->id();
            $table->string('title', 80);
            $table->string('slug', 80);
            $table->text('body');
            $table->foreignId('user_id')->index()->constrained();
            $table->tinyInteger('is_locked')->index()->default(0);
            $table->tinyInteger('is_sticky')->index()->default(0);
            $table->timeStamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('pool-forum.table_names.posts'));
    }
};
