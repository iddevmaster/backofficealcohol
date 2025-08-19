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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            // The serial_num field is a unique string.
            $table->string('serial_num')->unique();
            // ip_address can be a string and is nullable.
            $table->string('ip_address')->nullable();
            // These sensor-related fields are nullable strings.
            $table->string('sensor_sn')->nullable();
            $table->string('sensor_body_sn')->nullable();
            // The Raspberry Pi MAC address is also a nullable string.
            $table->string('pi_mac_address')->nullable();
            // The created_date field is a datetime.
            $table->dateTime('created_date');
            // Latitude and Longitude are float values and can be nullable.
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            // The tested_count is an integer with a default value of 0.
            $table->integer('tested_count')->default(0);
            // The last_calibration field is a date.
            $table->date('last_calibration');
            // The status field is an integer.
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
