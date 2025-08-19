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
        Schema::create('org_devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            
            // The serial_num field is a string and must be unique.
            $table->string('serial_num')->unique();
            
            // Foreign key for the branches table.
            $table->unsignedBigInteger('brn_id');
            $table->foreign('brn_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedBigInteger('org_id');
            $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');
            // The note field is a string and can be nullable.
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_devices');
    }
};
