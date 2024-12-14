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
        Schema::create('room_amenities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->boolean('wifi')->default(false);
            $table->boolean('cabinet')->default(false);
            $table->boolean('chair')->default(false);
            $table->boolean('table')->default(false);
            $table->boolean('air_conditioning')->default(false);
            $table->boolean('electric_fan')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_amenity');
    }
};
