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
        Schema::create('sensor_readings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cage_id')->constrained()->cascadeOnDelete();

            // tipe sensor
            $table->enum('type', ['dht11', 'dht22']);

            // data
            $table->float('temperature')->nullable();
            $table->float('humidity')->nullable();

            $table->timestamps();

            // index untuk performa
            $table->index(['cage_id', 'type']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_readings');
    }
};
