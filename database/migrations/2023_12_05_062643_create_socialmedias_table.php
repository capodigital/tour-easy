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
            $table->text('description');
            $table->string('url');
            $table->foreignId('typeredes_id')->nullable()->references('id')->on('typeredes');
            $table->unsignedBigInteger('socialmediaable_id');
            $table->string('socialmediaable_type');
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
