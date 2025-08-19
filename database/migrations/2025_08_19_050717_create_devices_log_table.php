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
        Schema::create('devices_log', function (Blueprint $table) {
            $table->id();
            $table->string('serial_num')->unique(); // string unique
            $table->string('ip_address')->nullable(); // string nullable
            $table->float('latitude')->nullable(); // float nullable
            $table->float('longitude')->nullable(); // float nullable
            $table->integer('tested_count')->default(0); // int default=0
            $table->dateTime('timestamp'); // datetime
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices_log');
    }
};
