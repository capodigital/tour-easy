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
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->string('google_id', 100)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('extra_phone', 30)->nullable();
            $table->string('manager', 100)->nullable();
            $table->string('email', 250)->nullable();
            $table->string('gis', 250)->nullable();
            $table->text('notes')->nullable();
            $table->string('address', 250)->nullable();
            $table->foreignId('typeplace_id')->nullable()->references('id')->on('typeplaces')->onDelete('set null');
            $table->foreignId('city_id')->nullable()->references('id')->on('cities')->onDelete('set null');
            $table->foreignId('agency_id')->nullable()->references('id')->on('agencies')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
