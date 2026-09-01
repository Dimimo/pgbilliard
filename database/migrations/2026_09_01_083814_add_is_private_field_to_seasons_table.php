<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function up(): void
    {
        Schema::table('seasons', function (Blueprint $table) {
           $table->boolean('is_public')->default(true)->index()->after('cycle');
        });
    }

    public function down(): void
    {
        Schema::table('seasons', function (Blueprint $table) {
            $table->dropColumn('is_public');
            $table->dropIndex('seasons_is_public_index');
        });
    }
};
