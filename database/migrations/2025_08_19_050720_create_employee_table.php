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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            // The employee ID field, which is a unique string.
            $table->string('emp_id')->unique();

            // Fields for the employee's name.
            $table->string('prefix');
            $table->string('first_name');
            $table->string('last_name');

            // Contact and image fields, which are nullable.
            $table->string('phone')->nullable();
            $table->string('image')->nullable();

            // A boolean to track if a fingerprint is registered.
            $table->boolean('fingerprint_registered');
            $table->boolean('status');

            // Foreign key relationships to other tables, which are nullable.
            $table->unsignedBigInteger('dpm_id')->nullable();
            $table->foreign('dpm_id')->references('id')->on('departments')->onDelete('set null');

            $table->unsignedBigInteger('brn_id')->nullable();
            $table->foreign('brn_id')->references('id')->on('branches')->onDelete('set null');

            // Foreign key to the organizations table.
            $table->unsignedBigInteger('org_id');
            $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');

            // Adds created_at and updated_at columns for timestamps.
            $table->timestamps();

            // Adds a deleted_at column for soft deleting records.
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};
