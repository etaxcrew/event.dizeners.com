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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('about')->nullable();
            $table->unsignedInteger('stock');
            $table->decimal('price', 10, 2)->default(0);
            $table->date('ticket_date')->nullable();
            $table->time('open_time_at')->nullable();
            $table->time('closed_time_at')->nullable();
            $table->timestamp('end_date_sale')->nullable();
            $table->integer('max_per_user')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
