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
        Schema::create('tambon', function (Blueprint $table) {
            $table->id();
            $table->string('tambon_code');
            $table->string('name');
            $table->integer('amphur_id');
            $table->integer('province_id');
            $table->string('tambon_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tambon');
    }
};
