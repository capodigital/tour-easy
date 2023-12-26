<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->default(null);
            $table->string('url')->nullable()->default(null);
            $table->string('document_path')->nullable()->default(null);
            $table->integer('size')->nullable()->default(null);
            $table->string('ext')->nullable()->default(null);
            $table->unsignedBigInteger('documentable_id')->nullable();
            $table->string('documentable_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
