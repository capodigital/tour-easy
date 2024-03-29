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
        Schema::create('socialmedias', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->foreignId('typesocialmedia_id')->nullable()->references('id')->on('typesocialmedias');
            $table->unsignedBigInteger('socialmediaable_id')->nullable();
            $table->string('socialmediaable_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socialmedias');
    }
};
