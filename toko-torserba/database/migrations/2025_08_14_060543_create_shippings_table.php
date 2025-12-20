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
        Schema::create('shippings', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID primary key
            $table->uuid('order_id')->unique(); // Setiap order hanya punya 1 shipping
            $table->string('courier', 50)->nullable(); // kurir internal/ekspedisi
            $table->string('tracking_number', 100)->nullable();
            $table->enum('status', ['dikemas', 'dikirim', 'diterima'])->default('dikemas');
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();

            // Foreign key ke orders
            $table->foreign('order_id')
                  ->references('id')
                  ->on('orders')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
