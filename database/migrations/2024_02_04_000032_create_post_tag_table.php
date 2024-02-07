<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create(config('pool-forum.table_names.post_tag'), function (Blueprint $table)
        {
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('forum_post_id')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('pool-forum.table_names.post_tag'));
    }
};
