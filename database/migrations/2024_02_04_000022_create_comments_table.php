<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('pool-forum.table_names.comments'), function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->foreignId('user_id')->index()->constrained();
            $table->foreignId('post_id')->index()->constrained()->onDelete('cascade');
            $table->timeStamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('pool-forum.table_names.comments'));
    }
};
