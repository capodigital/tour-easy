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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('platform', 100)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('itinerary_id')->nullable()->references('id')->on('itineraries')->onDelete('set null');
            $table->foreignId('tour_id')->nullable()->references('id')->on('tours')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
