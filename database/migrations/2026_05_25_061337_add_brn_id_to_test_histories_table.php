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
        Schema::table('test_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('brn_id')->nullable()->after('org_id');
            $table->foreign('brn_id')->references('id')->on('branches')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_histories', function (Blueprint $table) {
            $table->dropForeign(['brn_id']);
            $table->dropColumn('brn_id');
        });
    }
};
