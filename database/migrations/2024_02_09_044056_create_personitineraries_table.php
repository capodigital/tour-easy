<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personitineraries', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->default(2);
            $table->foreignId('person_id')->nullable()->references('id')->on('persons')->onDelete('cascade');
            $table->foreignId('itinerary_id')->nullable()->references('id')->on('itineraries')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personitineraries');
    }
};
