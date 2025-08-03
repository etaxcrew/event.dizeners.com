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
        Schema::table('tickets', function (Blueprint $table) {
            //
            $table->foreignId('organizer_id')->nullable()->constrained()->onDelete('cascade');
            $table->unsignedInteger('remaining')->nullable()->after('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['organizer_id']);
            $table->dropColumn(['organizer_id', 'remaining']);
        });
    }
};
