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
        Schema::create('users', function (Blueprint $table) {
            $table->id();                                  // pk
            $table->string('username')->unique();          // login name
            $table->string('password');                    // hashed
            $table->string('prefix_id');                      // เช่น Mr., คุณ ฯลฯ
            $table->timestamp('email_verified_at')->nullable();                   // เช่น Mr., คุณ ฯลฯ
            $table->string('first_name');
            $table->string('last_name');
            $table->string('role_id');                     // เก็บเป็น string ตามสเปค
            $table->string('dpm_id')->nullable();          // department id
            $table->string('brn_id')->nullable();          // branch id
            $table->string('org_id')->nullable();          // organization id
            $table->string('phone')->nullable();
            $table->boolean('status')->default(true);      // active?
            $table->timestamps();
             $table->rememberToken();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('username')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
