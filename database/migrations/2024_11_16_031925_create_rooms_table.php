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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('thumbnail_image')->nullable();
            $table->json('main_images')->nullable();
            $table->enum('availability', ['available', 'not_available'])->default('available');
            $table->date('availability_date')->nullable(); 
              $table->string('type')->nullable();
              $table->string('wifi')->nullable();
              $table->longText('description')->nullable(); 
              $table->integer('occupancy')->nullable();
              $table->integer('number_of_beds')->nullable();
              $table->decimal('price', 10, 2)->nullable();
              $table->foreignId('boarding_house_id')->constrained()->onDelete('cascade')->nullable();
              $table->json('amenities')->nullable();
              $table->string('refrigerator')->nullable();
              $table->string('curfew')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
