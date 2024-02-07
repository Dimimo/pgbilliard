<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create(config('pool-forum.table_names.visits'), function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('user_id')->index()->constrained();
            $table->foreignId('forum_post_id')->index()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('pool-forum.table_names.visits'));
    }
};
