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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('tradename', 100)->nullable();
            $table->string('taxname', 100)->nullable();
            $table->string('taxcode', 100)->nullable();
            $table->string('address', 250)->nullable();
            $table->string('email', 250)->nullable();
            $table->string('manager', 250)->nullable();
            $table->string('manager_phone', 250)->nullable();
            $table->string('manager_email', 250)->nullable();
            $table->text('paydata')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('extra_phone', 30)->nullable();
            $table->string('contact', 100)->nullable();
            $table->string('contact_phone', 150)->nullable();
            $table->string('contact_email', 150)->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('supplier');
    }
};
