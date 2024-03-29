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
        Schema::create('countrytours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->nullable()->references('id')->on('tours')->onDelete('cascade');
            $table->foreignId('country_id')->nullable()->references('id')->on('countries')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countrytours');
    }
};
