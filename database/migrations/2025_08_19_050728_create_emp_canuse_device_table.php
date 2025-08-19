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
        Schema::create('emp_canuse_device', function (Blueprint $table) {
            $table->unsignedBigInteger('emp_id');
            $table->foreign('emp_id')->references('id')->on('employees')->onDelete('cascade');

            // Foreign key to the devices table (using the serial_num as the key).
            $table->string('device_sn');
            $table->foreign('device_sn')->references('serial_num')->on('devices')->onDelete('cascade');

            // Set a composite primary key to ensure uniqueness for each pair.
            $table->primary(['emp_id', 'device_sn']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_canuse_device');
    }
};
