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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            $table->unsignedBigInteger('pelanggan_id')->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('pelanggan_id');

            $table->foreignId('user_id')->constrained('users_pelanggan')->cascadeOnDelete();
        });
    }
};
