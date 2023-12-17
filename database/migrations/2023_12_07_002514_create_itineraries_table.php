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
        Schema::create('itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->nullable()->references('id')->on('tours')->onDelete('set null');
            $table->foreignId('place_id')->nullable()->references('id')->on('places')->onDelete('set null');
            $table->foreignId('city_start_id')->nullable()->references('id')->on('cities')->onDelete('set null');
            $table->foreignId('city_destination_id')->nullable()->references('id')->on('cities')->onDelete('set null');
            $table->foreignId('typeitinerary_id')->nullable()->references('id')->on('typeitineraries')->onDelete('set null');
            $table->foreignId('contact_id')->nullable()->references('id')->on('contacts')->onDelete('set null');
            $table->foreignId('supplier_id')->nullable()->references('id')->on('suppliers')->onDelete('set null');
            $table->string('name', 150)->nullable();
            $table->dateTime('startdate')->nullable();
            $table->dateTime('enddate')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('outoflour')->default(false);
            $table->string('carrier', 150)->nullable();
            $table->string('carrier_id', 150)->nullable();
            $table->time('showcheck');
            $table->time('showtime');
            $table->boolean('notify')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itineraries');
    }
};
