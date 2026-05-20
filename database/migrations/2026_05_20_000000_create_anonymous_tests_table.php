<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('anonymous_tests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('org_id')->constrained('organizations')->cascadeOnDelete();
            $table->string('device_id');
            $table->string('user_id'); // Dummy user ID (e.g. 10-digit random string/number)
            $table->string('scan_type')->default('alcohol');
            $table->string('result'); // pass or fail
            $table->float('value'); // alcohol level in mg% (0.0 to 600.0)
            $table->dateTime('scanned_at');
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anonymous_tests');
    }
};
