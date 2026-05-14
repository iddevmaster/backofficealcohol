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
        // New table for fingerprint and identification scans
        Schema::create('device_scans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->foreignId('org_id')->constrained('organizations')->cascadeOnDelete();
            $table->string('device_id');
            $table->string('scan_type'); // fingerprint, identification
            $table->string('result');    // match, no_match, identified, fail
            $table->dateTime('scanned_at');
            $table->timestamps();
        });

        // Update test_histories for alcohol scan outcomes
        Schema::table('test_histories', function (Blueprint $table) {
            $table->string('result')->nullable()->after('alcohol_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_histories', function (Blueprint $table) {
            $table->dropColumn('result');
        });
        Schema::dropIfExists('device_scans');
    }
};
