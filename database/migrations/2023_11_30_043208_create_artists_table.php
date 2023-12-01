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
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('stagename', 100)->nullable();
            $table->string('name', 50)->nullable();
            $table->string('lastname', 50)->nullable();
            $table->date('birthday')->nullable();
            $table->string('instagram', 250)->nullable();
            $table->string('facebook', 250)->nullable();
            $table->string('twitter', 250)->nullable();
            $table->string('tiktok', 250)->nullable();
            $table->string('youtube', 250)->nullable();
            $table->string('spotify', 250)->nullable();
            $table->string('applemusic', 250)->nullable();
            $table->string('amazonmusic', 250)->nullable();
            $table->string('tidal', 250)->nullable();
            $table->string('web', 250)->nullable();
            $table->text('extraprofile')->nullable();
            $table->text('tags')->nullable();
            $table->text('notes')->nullable();
            $table->string('image', 150)->nullable();
            $table->foreignId('agency_id')->nullable()->references('id')->on('agencies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
