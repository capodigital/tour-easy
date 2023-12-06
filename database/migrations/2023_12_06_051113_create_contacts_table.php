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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable();
            $table->string('lastname', 50)->nullable();
            $table->date('birthday')->nullable();
            $table->string('email', 250)->unique()->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('extra_phone', 30)->nullable();
            $table->enum('lang', ['Inglés','Español', 'Francés'])->nullable();
            $table->string('position', 150)->nullable();
            $table->boolean('notify')->default(false);
            $table->text('notes')->nullable();
            $table->foreignId('typecontact_id')->nullable()->references('id')->on('typecontacts')->onDelete('set null');
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
        Schema::dropIfExists('contacts');
    }
};
