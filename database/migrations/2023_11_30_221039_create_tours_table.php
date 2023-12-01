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

        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('tourname', 100)->nullable();
            $table->date('startdate')->nullable();
            $table->date('enddate')->nullable();
            $table->string('web', 250)->nullable();
            $table->string('tourcartel', 150)->nullable();
            $table->foreignId('agency_id')->references('id')->on('agencies')->onDelete('set null');
            $table->foreignId('artist_id')->references('id')->on('artists')->onDelete('set null');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
