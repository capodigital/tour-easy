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
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('tradename', 100)->unique()->nullable();
            $table->string('taxname', 100)->unique()->nullable();
            $table->string('taxcode', 30)->unique()->nullable();
            $table->string('owner', 50)->nullable();
            $table->string('address', 250)->nullable();
            $table->string('email', 250)->unique()->nullable();
            $table->string('password');
            $table->text('notes')->nullable();
            $table->string('phone', 30)->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->foreignId('city_id')->nullable()->references('id')->on('cities')->onDelete('set null');
            $table->foreignId('typeagency_id')->nullable()->references('id')->on('typeagencies')->onDelete('set null');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agencies');
    }
};
