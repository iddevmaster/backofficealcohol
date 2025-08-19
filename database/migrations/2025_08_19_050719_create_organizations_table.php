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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
                       // The org_id field is a universally unique identifier (UUID).
            $table->uuid('org_id');
            
            // The name field is a string.
            $table->string('name');
            
            // The logo field is a nullable string.
            $table->string('logo')->nullable();
            
            // The status field is a boolean (true/false).
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
