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
        if (! Schema::hasTable('venues')) {
            Schema::create('venues', function (Blueprint $table) {
                $table->id();
                $table->string('name', 24);
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->string('address')->nullable();
                $table->string('contact_name', 24)->nullable();
                $table->string('contact_nr', 16)->nullable();
                $table->text('remark')->nullable();
                $table->decimal('lat', 12, 7)->nullable();
                $table->decimal('lng', 12, 7)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
