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
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boarding_house_id')->constrained()->onDelete('cascade');
            // // $table->integer('bathrooms')->default(0);
            // $table->boolean('wifi')->default(false);
            // $table->boolean('cctv')->default(false);
            // // $table->boolean('kitchen_use')->default(false);
            // $table->boolean('laundry_service')->default(false);
            // $table->boolean('cabinet')->default(false);
            // $table->boolean('chair')->default(false);
            // $table->boolean('table')->default(false);
            // $table->boolean('air_conditioning')->default(false);
            // $table->boolean('kitchen')->default(false);
            // $table->boolean('study_area')->default(false);
            // $table->boolean('outdoor_space')->default(false);

            $table->enum('wifi', ['available', 'shared', 'in-room,', 'not-available'])->nullable()->default('available');
            $table->enum('cctv', ['available', 'shared', 'in-room', 'not-available'])->nullable()->default('available');
            $table->enum('kitchen', ['available', 'shared', 'in-room', 'not-available'])->nullable()->default('available');
            $table->enum('laundry_service', ['available', 'shared', 'in-room', 'not-available'])->nullable()->default('available');
            $table->enum('electric_bill', ['available', 'shared', 'separate', 'not-available'])->nullable()->default('available');
            $table->enum('water_bill', ['available', 'shared', 'separate', 'not-available'])->nullable()->default('available');
            $table->enum('air_conditioning', ['available', 'shared', 'in-room', 'not-available'])->nullable()->default('available');
            $table->enum('refrigerator', ['available', 'shared', 'in-room', 'not-available'])->nullable()->default('available');
            $table->integer('bathrooms')->default(0); // Bathrooms
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amenities');
    }
};
