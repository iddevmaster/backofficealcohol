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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            // The employee ID field, which is a unique string.
            $table->string('emp_id')->unique();

            $table->unsignedInteger('emp_no');

            // Fields for the employee's name.
            $table->string('prefix_id');
            $table->string('first_name');
            $table->string('last_name');

            // Contact and image fields, which are nullable.
            $table->string('phone')->nullable();
            $table->string('image')->nullable();

            // A boolean to track if a fingerprint is registered.
            $table->boolean('fingerprint_registered')->default(false);
            $table->boolean('status')->default(true);

            // Foreign key relationships to other tables, which are nullable.
            $table->foreignId('dpm_id')
                ->nullable()
                ->constrained('departments')
                ->nullOnDelete();

            $table->foreignId('brn_id')
                ->nullable()
                ->constrained('branches')
                ->nullOnDelete();

            // Foreign key to the organizations table.
            $table->foreignId('org_id')
                ->constrained('organizations')
                ->cascadeOnDelete();

            // Adds created_at and updated_at columns for timestamps.
            $table->timestamps();

            // Adds a deleted_at column for soft deleting records.
            $table->softDeletes();

            // กัน employee_no ซ้ำใน organization เดียวกัน
            $table->unique(
                ['org_id', 'emp_no'],
                'org_employee_no_unique'
            );
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
