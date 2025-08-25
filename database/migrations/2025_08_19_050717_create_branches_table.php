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
            Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('brn_id');
            $table->string('name');
            $table->string('address');
            $table->integer('tambon_id');
            $table->integer('amphur_id');
            $table->integer('province_id');
            $table->string('org_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
