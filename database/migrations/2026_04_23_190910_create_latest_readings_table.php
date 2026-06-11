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
        Schema::create('latest_readings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cage_id')->constrained()->cascadeOnDelete();

            // DHT11
            $table->float('temperature_dht11')->nullable();
            $table->float('humidity_dht11')->nullable();

            // DHT22
            $table->float('temperature_dht22')->nullable();
            $table->float('humidity_dht22')->nullable();

            $table->timestamp('recorded_at')->nullable();

            $table->timestamps();

            // 1 kandang hanya 1 data realtime
            $table->unique('cage_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('latest_readings');
    }
};
