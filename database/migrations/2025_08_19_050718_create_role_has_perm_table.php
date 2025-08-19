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
        Schema::create('role_has_perm', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('perm_id');

            // Set the foreign key constraints. This assumes you have 'roles' and 'permissions' tables.
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('perm_id')->references('id')->on('permissions')->onDelete('cascade');

            // Set a primary key for the combination of both IDs to prevent duplicate entries.
            $table->primary(['role_id', 'perm_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_has_perm');
    }
};
