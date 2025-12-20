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
       // Migration users
    Schema::create('users', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamps();
    });

    // Migration orders
    Schema::create('orders', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('user_id');
        $table->decimal('subtotal', 12, 2)->default(0);
        $table->decimal('shipping_cost', 12, 2)->default(0);
        $table->decimal('total_amount', 12, 2)->default(0);
        $table->text('shipping_address');
        $table->enum('shipping_status', ['dikemas', 'dikirim', 'diterima'])->default('dikemas');
        $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
        $table->string('payment_method', 50)->nullable();
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
    });


        }

        /**
         * Reverse the migrations.
         */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
