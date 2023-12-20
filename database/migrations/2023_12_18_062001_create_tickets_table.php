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
            $table->string('name', 100)->nullable();
            $table->string('lastname', 100)->nullable();
            $table->string('email', 250)->nullable();
            $table->float('amount')->nullable();
            $table->string('wallet', 100)->nullable();
            $table->string('chain', 100)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('itinerary_id')->nullable()->references('id')->on('itineraries')->onDelete('set null');
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
