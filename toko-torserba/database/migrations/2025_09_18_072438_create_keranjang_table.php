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
    Schema::create('keranjangs', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id')->nullable();
    $table->unsignedBigInteger('product_id');
    $table->integer('jumlah')->default(1);
    $table->decimal('harga', 10, 2)->nullable();
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::table('keranjang', function (Blueprint $table) {
            $table->dropColumn('harga');
        });
    }

};
